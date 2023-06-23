<?php

declare(strict_types=1);

namespace SUDHAUS7\ResponsivePicture\ViewHelpers\Be;

use Doctrine\DBAL\Driver\Exception;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Resource\Exception\FileDoesNotExistException;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class FileVariantsViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerArgument(
            'file',
            File::class,
            'The file',
            true
        );
        $this->registerArgument(
            'fieldName',
            'string',
            'Field name',
            true
        );
        $this->registerArgument(
            'payload',
            'string',
            'Wizard payload JSON',
            true
        );
    }

    /**
     * @return array<int|string, mixed>
     * @throws Exception
     * @throws FileDoesNotExistException
     */
    public function render(): array
    {
        $mediaVariants = [];
        /** @var File $file */
        $file = $this->arguments['file'];
        $fieldName = $this->arguments['fieldName'];
        $payload = json_decode($this->arguments['payload'], true);
        $payloadArgs = json_decode($payload['arguments'], true);
        $mediaVariants['original'] = [
            'wizardPayload' => json_encode($payload),
            'cropVariants' => $payloadArgs['cropVariants'],
        ];
        $preparedPayloadArguments = [];
        foreach ($payloadArgs['cropVariants'] as $variant => $config) {
            $preparedPayloadArguments[$variant] = [
                $variant => $config,
            ];
        }
        $field = GeneralUtility::trimExplode('][', $fieldName);
        $sysFileReferenceId = 0;
        foreach ($field as $possibleId) {
            if (MathUtility::canBeInterpretedAsInteger($possibleId)) {
                $sysFileReferenceId = (int)$possibleId;
                break;
            }
        }
        if ($sysFileReferenceId > 0) {
            $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
            $referenceDataset = $this->getReferencedMediaVariants($sysFileReferenceId);
            foreach ($referenceDataset as $variant) {
                $variant['image'] = $resourceFactory->getFileObject($variant['uid_local']);
                $wizardPayload = $this->getWizardPayload(
                    $preparedPayloadArguments[$variant['media_width']] ?? [],
                    $variant['image']
                );
                $variant['cropVariants'] = $preparedPayloadArguments[$variant['media_width']];
                $variant['wizardPayload'] = json_encode($wizardPayload);
                $mediaVariants[$variant['media_width']] = $variant;
                unset($mediaVariants['original']['cropVariants'][$variant['media_width']]);
            }
        }

        if (count($mediaVariants['original']['cropVariants'] ?? []) > 0) {
            $mediaVariants['original']['wizardPayload'] = json_encode($this->getWizardPayload(
                $mediaVariants['original']['cropVariants'] ?? [],
                $file
            ));
        } else {
            unset($mediaVariants['original']);
        }

        return $mediaVariants;
    }

    /**
     * @return array<int|string, mixed>
     * @throws Exception
     */
    private function getReferencedMediaVariants(int $referenceId): array
    {
        $db = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('sys_file_reference');
        $statement = $db
            ->select(
                ['uid', 'uid_local', 'media_width'],
                'sys_file_reference',
                [
                    'uid_foreign' => $referenceId,
                    'tablenames' => 'sys_file_reference',
                    'fieldname' => 'picture_variants',
                ]
            );
        return $statement->fetchAllAssociative();
    }

    /**
     * @param array<int|string, mixed> $cropVariants
     * @param File $image
     * @return array{cropVariants: array<int|string, mixed>, image: int, arguments: string, signature: string}
     */
    protected function getWizardPayload(array $cropVariants, File $image): array
    {
        $uriArguments = [];
        $arguments = [
            'cropVariants' => $cropVariants,
            'image' => $image->getUid(),
        ];
        $uriArguments['arguments'] = json_encode($arguments) ?: '';
        $uriArguments['signature'] = GeneralUtility::hmac((string)($uriArguments['arguments'] ?? ''), 'ajax_wizard_image_manipulation');

        return $uriArguments;
    }
}
