<?php

declare(strict_types=1);

call_user_func(function () {
    $newColumns = [
        'picture_variants' => [
            'label' => 'LLL:EXT:picture/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.picture_variants',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('picture_variants', [
                'appearance' => [
                    'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                ],
                // custom configuration for displaying fields in the overlay/reference table
                // to use the imageoverlayPalette instead of the basicoverlayPalette
                'overrideChildTca' => [
                    'types' => [
                        '0' => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                                --palette--;;audioOverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                                --palette--;;videoOverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ]
                    ],
                ],
            ], $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'])
        ],
        'media_width' => [
            'label' => 'LLL:EXT:picture/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.media_width',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Desktop', '(min-width: 1200px)'],
                    ['Tablet', '(min-width: 768px)'],
                    ['Mobile', '(min-width: 300px)'],
                ],
            ],
            'displayCond' => 'FIELD:tablenames:=:sys_file_reference'
        ],
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_file_reference', $newColumns);
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('sys_file_reference', 'imageoverlayPalette','--linebreak--,picture_variants', 'after:crop');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('sys_file_reference', 'imageoverlayPalette','media_width', 'after:title');

    $GLOBALS['TCA']['sys_file_reference']['columns']['link']['displayCond'] = 'FIELD:tablenames:!=:sys_file_reference';
    $GLOBALS['TCA']['sys_file_reference']['columns']['title']['displayCond'] = 'FIELD:tablenames:!=:sys_file_reference';
    $GLOBALS['TCA']['sys_file_reference']['columns']['alternative']['displayCond'] = 'FIELD:tablenames:!=:sys_file_reference';
    $GLOBALS['TCA']['sys_file_reference']['columns']['description']['displayCond'] = 'FIELD:tablenames:!=:sys_file_reference';
    $GLOBALS['TCA']['sys_file_reference']['columns']['picture_variants']['displayCond'] = 'FIELD:tablenames:!=:sys_file_reference';
});
