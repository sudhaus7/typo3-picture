<?php

declare(strict_types=1);

namespace SUDHAUS7\ResponsivePicture\Overrides;

use TYPO3\CMS\Backend\Form\Element\ImageManipulationElement;
use TYPO3\CMS\Backend\Form\NodeFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class EnhancedImageManipulationElement extends ImageManipulationElement
{
    public function __construct(NodeFactory $nodeFactory, array $data)
    {
        parent::__construct($nodeFactory, $data);
        $this->templateView->setTemplatePathAndFilename(
            GeneralUtility::getFileAbsFileName(
                'EXT:responsive_picture/Resources/Private/Templates/ImageManipulation/ImageManipulationElement.html'
            )
        );
    }
}
