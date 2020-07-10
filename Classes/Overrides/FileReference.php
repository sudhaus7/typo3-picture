<?php


namespace SUDHAUS7\ResponsivePicture\Overrides;

use PDO;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class FileReference
 *
 * @package SUDHAUS7\Picture\Overrides
 */
class FileReference extends \TYPO3\CMS\Core\Resource\FileReference
{
    
    /**
     * @var null|string
     */
    protected $mediaquerykey= null;

    /**
     * @var null|array
     */
    protected $variants = null;

    /**
     * @var ResourceFactory
     */
    private $factory;

    /**
     * FileReference constructor.
     *
     * @param array $fileReferenceData
     * @param null $factory
     */
    public function __construct(array $fileReferenceData, $factory = null)
    {
        parent::__construct($fileReferenceData, $factory);
        $this->factory = GeneralUtility::makeInstance(ResourceFactory::class);
    
    }

    /**
     * @return array
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
                        $db->expr()->andX(...[
                            $db->expr()->eq('uid_foreign', $properties['uid']),
                            $db->expr()->eq('tablenames', $db->quote('sys_file_reference')),
                            $db->expr()->eq('fieldname', $db->quote('picture_variants')),
                        ])
                    )
                    ->orderBy('sorting_foreign')
                    ->execute();

                $collectedmediaquery = [];
                $unsortedvariants = [];
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $variant = $this->factory->getFileReferenceObject($row['uid'], $row);
                    $collectedmediaquery[] = $variant->getProperties()['media_width'];
                    $unsortedvariants[] = $variant;
                }
                if(isset($GLOBALS['TSFE']->config['config']['tx_responsivepicture.']['autocreatevariations']) && (bool)$GLOBALS['TSFE']->config['config']['tx_responsivepicture.']['autocreatevariations']) {

                    foreach ($GLOBALS['TSFE']->config['config']['tx_responsivepicture.']['sizes.'] as $k=>$config) {
                        if (!in_array($config['key'],$collectedmediaquery)) {
                            $variant = clone $this;
                            $variant->markAsVariation($config['key']);
                            $unsortedvariants[] = $variant;
                        }
                    }
    
                }
    
                // second pass for sorting
                if (isset($GLOBALS['TSFE']->config['config']['tx_responsivepicture.'])) {
    
                    foreach ( $GLOBALS['TSFE']->config['config']['tx_responsivepicture.']['sizes.'] as $k => $config ) {
                        foreach ( $unsortedvariants as $variant ) {
                            if ( $variant->getProperties()['media_width'] === $config['key'] ) {
                                $this->variants[] = $variant;
                            }
                        }
                    }
                }
            }
        }
        return $this->variants;
    }
    
    public function isVariant() : bool
    {
        
        if ($this->mediaquerykey !== null) return true;
        
        $properties = $this->getProperties();
    
        // this doesn't need to run if we actually are a variant already
        return $properties['tablenames'] === 'sys_file_reference'
            && $properties['fieldname'] === 'picture_variants';
    }
    
    public function markAsVariation(string $mediaquerykey) : void
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
    public function getMediaquery() : string
    {
        if ($this->isVariant()) {
            if ($this->mediaquerykey !== null) {
                foreach ($GLOBALS['TSFE']->config['config']['tx_responsivepicture.']['sizes.'] as $key=>$config) {
                    if ($config['key'] === $this->mediaquerykey) {
                        return $config['mediaquery'];
                    }
                }
            }
            $properties = $this->getProperties();
            if (isset($properties['media_width']) && isset($GLOBALS['TSFE']->config['config']['tx_responsivepicture.']['sizes.'])) {
    
                foreach ( $GLOBALS['TSFE']->config['config']['tx_responsivepicture.']['sizes.'] as $key => $config ) {
                    if ( $config['key'] === $properties['media_width'] ) {
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
    public function getVariationmaxwidth() : string
    {
        if ($this->isVariant()) {
            if ($this->mediaquerykey !== null) {
                foreach ($GLOBALS['TSFE']->config['config']['tx_responsivepicture.']['sizes.'] as $key=>$config) {
                    if ($config['key'] === $this->mediaquerykey) {
                        return $config['maxW'];
                    }
                }
            }
            $properties = $this->getProperties();
            if (isset($properties['media_width']) && isset($GLOBALS['TSFE']->config['config']['tx_responsivepicture.']['sizes.'])) {
                foreach ($GLOBALS['TSFE']->config['config']['tx_responsivepicture.']['sizes.'] as $key=>$config) {
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
    public function getVariationmaxheight() : string
    {
        $height = '';
        if ($this->isVariant()) {
            if ($this->mediaquerykey !== null) {
                foreach ($GLOBALS['TSFE']->config['config']['tx_responsivepicture.']['sizes.'] as $key=>$config) {
                    if ($config['key'] === $this->mediaquerykey) {
                        return $config['maxH'];
                    }
                }
            }
            $properties = $this->getProperties();
            if (isset($properties['media_width']) && isset($GLOBALS['TSFE']->config['config']['tx_responsivepicture.']['sizes.'])) {
                foreach ($GLOBALS['TSFE']->config['config']['tx_responsivepicture.']['sizes.'] as $key=>$config) {
                    if ($config['key'] === $properties['media_width']) {
                        $height = $config['maxH'];
                    }
                }
            }
        }
        return '';
    }
}
