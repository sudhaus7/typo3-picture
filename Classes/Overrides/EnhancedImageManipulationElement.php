<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 project.
 *
 * @author Frank Berger <fberger@sudhaus7.de>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace SUDHAUS7\ResponsivePicture\Overrides;

use Override;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Backend\Form\Element\ImageManipulationElement;
use TYPO3\CMS\Backend\Form\Event\ModifyImageManipulationPreviewUrlEvent;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\View\BackendViewFactory;
use TYPO3\CMS\Core\Crypto\HashService;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;

class EnhancedImageManipulationElement extends ImageManipulationElement
{
    public function __construct(
        private readonly BackendViewFactory $backendViewFactory,
        private readonly UriBuilder $uriBuilder,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly ResourceFactory $resourceFactory,
        private readonly HashService $hashService,
    ) {
        parent::__construct($backendViewFactory, $uriBuilder, $eventDispatcher, $resourceFactory, $hashService);
    }

    #[Override]
    public function render(): array
    {
        $resultArray = $this->initializeResultArray();
        $parameterArray = $this->data['parameterArray'];
        $config = $this->populateConfiguration($parameterArray['fieldConf']['config']);

        $file = $this->getFile($this->data['databaseRow'], $config['file_field']);
        if (!$file) {
            // Early return in case we do not find a file
            return $resultArray;
        }

        $config = $this->processConfiguration($config, $parameterArray['itemFormElValue'], $file);

        $fieldInformationResult = $this->renderFieldInformation();
        $fieldInformationHtml = $fieldInformationResult['html'];
        $resultArray = $this->mergeChildReturnIntoExistingResult($resultArray, $fieldInformationResult, false);

        $fieldControlResult = $this->renderFieldControl();
        $fieldControlHtml = $fieldControlResult['html'];
        $resultArray = $this->mergeChildReturnIntoExistingResult($resultArray, $fieldControlResult, false);

        $fieldWizardResult = $this->renderFieldWizard();
        $fieldWizardHtml = $fieldWizardResult['html'];
        $resultArray = $this->mergeChildReturnIntoExistingResult($resultArray, $fieldWizardResult, false);

        $arguments = [
            'fieldInformation' => $fieldInformationHtml,
            'fieldControl' => $fieldControlHtml,
            'fieldWizard' => $fieldWizardHtml,
            'isAllowedFileExtension' => in_array(strtolower($file->getExtension()), GeneralUtility::trimExplode(',', strtolower((string)$config['allowedExtensions'])), true),
            'image' => $file,
            'formEngine' => [
                'field' => [
                    'value' => $parameterArray['itemFormElValue'],
                    'name' => $parameterArray['itemFormElName'],
                ],
                'validation' => '[]',
            ],
            'config' => $config,
            'wizardUri' => $this->getWizardUri(),
            'wizardPayload' => json_encode($this->getWizardPayload($config['cropVariants'], $file)),
            'previewUrl' => $this->eventDispatcher->dispatch(
                new ModifyImageManipulationPreviewUrlEvent($this->data['databaseRow'], $config, $file)
            )->getPreviewUrl(),
        ];

        if ($arguments['isAllowedFileExtension']) {
            $resultArray['javaScriptModules'][] = JavaScriptModuleInstruction::create(
                '@typo3/backend/image-manipulation.js'
            )->invoke('initializeTrigger');
            $arguments['formEngine']['field']['id'] = StringUtility::getUniqueId('formengine-image-manipulation-');
            if ($config['required'] ?? false) {
                $arguments['formEngine']['validation'] = $this->getValidationDataAsJsonString(['required' => true]);
            }
        }

        $view = $this->backendViewFactory->create($this->data['request'], ['sudhaus7/responsive-picture']);
        $view->assignMultiple($arguments);
        $resultArray['html'] = $this->wrapWithFieldsetAndLegend($view->render('Form/ImageManipulationElement'));

        return $resultArray;
    }
}
