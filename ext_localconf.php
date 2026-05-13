<?php

use TYPO3\CMS\Backend\Form\Element\ImageManipulationElement;
use SUDHAUS7\ResponsivePicture\Overrides\EnhancedImageManipulationElement;
use TYPO3\CMS\Core\Resource\FileReference;
use SUDHAUS7\ResponsivePicture\Hooks\ManipulateCroppingReference;

(static function (): void {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][ImageManipulationElement::class] = [
        'className' => EnhancedImageManipulationElement::class,
    ];

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][FileReference::class] = [
        'className' => \SUDHAUS7\ResponsivePicture\Overrides\FileReference::class,
    ];

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['responsive_picture'] =
        ManipulateCroppingReference::class;
})();
