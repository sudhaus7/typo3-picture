<?php

namespace SUDHAUS7\ResponsivePicture\Overrides;

use Doctrine\DBAL\Exception;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Resource\Exception\FileDoesNotExistException;
use TYPO3\CMS\Core\Resource\Exception\ResourceDoesNotExistException;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class FileReference
 */
class FileReference extends \TYPO3\CMS\Core\Resource\FileReference
{
    protected ?string $mediaquerykey = null;
    protected ?array $variants = null;
    private ResourceFactory $factory;

    /**
     * FileReference constructor.
     *
     * @param array $fileReferenceData
     * @param null $factory
     * @throws FileDoesNotExistException
     */
    public function __construct(array $fileReferenceData, $factory = null)
    {
        parent::__construct($fileReferenceData, $factory);
        $this->factory = GeneralUtility::makeInstance(ResourceFactory::class);
    }

    /**
     * @return array
     * @throws Exception
     * @throws ResourceDoesNotExistException
     */
    public function getVariants(): array
    {
        if ($this->variants === null) {
            $this->variants = [];

            $properties = $this->getProperties();

            // this doesn't need to run if we actually are a variant already
            if ($properties['tablenames'] !== 'sys_file_reference'
                && $properties['fieldname'] !== 'picture_variants') {
                $db = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file_reference');

                $result = $db->select('*')
                    ->from('sys_file_reference')
                    ->where(
                        $db->expr()->and(
                            $db->expr()->eq('uid_foreign', $properties['uid']),
                            $db->expr()->eq('tablenames', $db->quote('sys_file_reference')),
                            $db->expr()->eq('fieldname', $db->quote('picture_variants')),
                        )
                    )
                    ->orderBy('sorting_foreign')
                    ->executeQuery();

                $collectedmediaquery = [];
                $unsortedvariants = [];
                while ($row = $result->fetchAssociative()) {
                    $variant = $this->factory->getFileReferenceObject($row['uid'], $row);
                    $collectedmediaquery[] = $variant->getProperties()['media_width'];
                    $unsortedvariants[] = $variant;
                }
                if (
                    isset($GLOBALS['TYPO3_REQUEST']->getAttribute('frontend.typoscript')->getConfigArray()['tx_responsivepicture.']['autocreatevariations'])
                    && (bool)$GLOBALS['TYPO3_REQUEST']->getAttribute('frontend.typoscript')->getConfigArray()['tx_responsivepicture.']['autocreatevariations']
                ) {
                    foreach ($GLOBALS['TYPO3_REQUEST']->getAttribute('frontend.typoscript')->getConfigArray()['tx_responsivepicture.']['sizes.'] as $config) {
                        if (isset($config['key']) && !in_array($config['key'], $collectedmediaquery)) {
                            $variant = clone $this;
                            $variant->markAsVariation($config['key']);
                            $unsortedvariants[] = $variant;
                        }
                    }
                }

                // second pass for sorting
                if (isset($GLOBALS['TYPO3_REQUEST']->getAttribute('frontend.typoscript')->getConfigArray()['tx_responsivepicture.'])) {
                    foreach ($GLOBALS['TYPO3_REQUEST']->getAttribute('frontend.typoscript')->getConfigArray()['tx_responsivepicture.']['sizes.'] as $config) {
                        foreach ($unsortedvariants as $variant) {
                            if (isset($config['key']) && $variant->getProperties()['media_width'] === $config['key']) {
                                $this->variants[] = $variant;
                            }
                        }
                    }
                }
            }
        }
        return $this->variants;
    }

    public function isVariant(): bool
    {
        if ($this->mediaquerykey !== null) {
            return true;
        }

        $properties = $this->getProperties();

        // this doesn't need to run if we actually are a variant already
        return $properties['tablenames'] === 'sys_file_reference'
            && $properties['fieldname'] === 'picture_variants';
    }

    private function markAsVariation(string $mediaquerykey): void
    {
        $this->getProperties();
        $this->mediaquerykey = $mediaquerykey;
        $this->mergedProperties['media_width'] = $mediaquerykey;
        $this->mergedProperties['tablenames'] = 'sys_file_reference';
        $this->mergedProperties['fieldname'] = 'picture_variants';
    }

    /**
     * @return string
     */
    public function getMediaquery(): string
    {
        if ($this->isVariant()) {
            if ($this->mediaquerykey !== null) {
                foreach ($GLOBALS['TYPO3_REQUEST']->getAttribute('frontend.typoscript')->getConfigArray()['tx_responsivepicture.']['sizes.'] as $config) {
                    if ($config['key'] === $this->mediaquerykey) {
                        return $config['mediaquery'];
                    }
                }
            }
            $properties = $this->getProperties();
            if (isset($properties['media_width']) && isset($GLOBALS['TYPO3_REQUEST']->getAttribute('frontend.typoscript')->getConfigArray()['tx_responsivepicture.']['sizes.'])) {
                foreach ($GLOBALS['TYPO3_REQUEST']->getAttribute('frontend.typoscript')->getConfigArray()['tx_responsivepicture.']['sizes.'] as $config) {
                    if ($config['key'] === $properties['media_width']) {
                        return $config['mediaquery'];
                    }
                }
            }
        }
        return '';
    }

    /**
     * @return string
     */
    public function getVariationmaxwidth(): string
    {
        if ($this->isVariant()) {
            if ($this->mediaquerykey !== null) {
                foreach ($GLOBALS['TYPO3_REQUEST']->getAttribute('frontend.typoscript')->getConfigArray()['tx_responsivepicture.']['sizes.'] as $config) {
                    if ($config['key'] === $this->mediaquerykey) {
                        return $config['maxW'];
                    }
                }
            }
            $properties = $this->getProperties();
            if (isset($properties['media_width']) && isset($GLOBALS['TYPO3_REQUEST']->getAttribute('frontend.typoscript')->getConfigArray()['tx_responsivepicture.']['sizes.'])) {
                foreach ($GLOBALS['TYPO3_REQUEST']->getAttribute('frontend.typoscript')->getConfigArray()['tx_responsivepicture.']['sizes.'] as $config) {
                    if ($config['key'] === $properties['media_width']) {
                        return $config['maxW'];
                    }
                }
            }
        }
        return '';
    }

    /**
     * @return string
     */
    public function getVariationmaxheight(): string
    {
        $height = '';
        if ($this->isVariant()) {
            if ($this->mediaquerykey !== null) {
                foreach ($GLOBALS['TYPO3_REQUEST']->getAttribute('frontend.typoscript')->getConfigArray()['tx_responsivepicture.']['sizes.'] as $config) {
                    if ($config['key'] === $this->mediaquerykey) {
                        return $config['maxH'];
                    }
                }
            }
            $properties = $this->getProperties();
            if (isset($properties['media_width']) && isset($GLOBALS['TYPO3_REQUEST']->getAttribute('frontend.typoscript')->getConfigArray()['tx_responsivepicture.']['sizes.'])) {
                foreach ($GLOBALS['TYPO3_REQUEST']->getAttribute('frontend.typoscript')->getConfigArray()['tx_responsivepicture.']['sizes.'] as $config) {
                    if (isset($config['key']) && $config['key'] === $properties['media_width']) {
                        $height = $config['maxH'];
                    }
                }
            }
        }
        return '';
    }
}
