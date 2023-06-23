<?php

(static function () {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Backend\Form\Element\ImageManipulationElement::class] = [
        'className' => \SUDHAUS7\ResponsivePicture\Overrides\EnhancedImageManipulationElement::class,
    ];

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Core\Resource\FileReference::class] = [
        'className' => \SUDHAUS7\ResponsivePicture\Overrides\FileReference::class,
    ];

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['responsive_picture'] =
        \SUDHAUS7\ResponsivePicture\Hooks\ManipulateCroppingReference::class;
})();
