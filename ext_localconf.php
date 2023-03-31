<?php

(static function () {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Backend\Form\Element\ImageManipulationElement::class] = [
        'className' => \SUDHAUS7\ResponsivePicture\Overrides\EnhancedImageManipulationElement::class,
    ];

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Core\Resource\FileReference::class] = [
        'className' => \SUDHAUS7\ResponsivePicture\Overrides\FileReference::class,
    ];
})();
