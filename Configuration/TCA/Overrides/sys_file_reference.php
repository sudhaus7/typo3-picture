<?php

declare(strict_types=1);

(static function (): void {
    $GLOBALS['TCA']['sys_file_reference']['palettes']['variantsPalette'] = [
        'label' => 'LLL:EXT:responsive_picture/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.variantsPalette',
        'showitem' => 'media_width',
    ];

    $GLOBALS['TCA']['sys_file_reference']['columns']['media_width']['label'] = 'LLL:EXT:responsive_picture/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.media_width';
    $GLOBALS['TCA']['sys_file_reference']['columns']['media_width']['config']['type'] = 'select';
    $GLOBALS['TCA']['sys_file_reference']['columns']['media_width']['config']['renderType'] = 'selectSingle';
    $GLOBALS['TCA']['sys_file_reference']['columns']['media_width']['config']['itemsProcFunc'] = \SUDHAUS7\ResponsivePicture\TCA\MediaWidthItemProcFunc::class . '->getMediaWidth';
    if (empty($GLOBALS['TCA']['sys_file_reference']['columns']['media_width']['config']['items'])) {
        $GLOBALS['TCA']['sys_file_reference']['columns']['media_width']['config']['items'] = [
            ['', null]
        ];
    }

    $newColumns = [
        'picture_variants' => [
            'label' => 'LLL:EXT:responsive_picture/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.picture_variants',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types',
            ]
        ],
    ];

    // override child TCA for all file types
    $newColumns['picture_variants']['config']['overrideChildTca']['types'] = [];
    foreach (\TYPO3\CMS\Core\Resource\FileType::cases() as $case) {
        $newColumns['picture_variants']['config']['overrideChildTca']['types'][$case->value] = [
            'showitem' => '
                --palette--;;variantsPalette,
                --palette--;;filePalette',
        ];
    }
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_file_reference', $newColumns);
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('sys_file_reference', 'imageoverlayPalette', '--linebreak--,picture_variants', 'after:crop');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('sys_file_reference', 'variantsPalette', 'media_width', 'after:title');
})();
