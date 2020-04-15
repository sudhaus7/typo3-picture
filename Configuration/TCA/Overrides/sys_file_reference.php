<?php

declare(strict_types=1);

call_user_func(function () {
    $GLOBALS['TCA']['sys_file_reference']['palettes']['variantsPalette'] = [
        'label' => 'LLL:EXT:responsive_picture/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.variantsPalette',
        'showitem' => 'media_width,--linebreak--,crop'
    ];
    $newColumns = [
        'picture_variants' => [
            'label' => 'LLL:EXT:responsive_picture/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.picture_variants',
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
                                --palette--;;variantsPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                                --palette--;;variantsPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                                --palette--;;variantsPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                                --palette--;;variantsPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                                --palette--;;variantsPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                                --palette--;;variantsPalette,
                                --palette--;;filePalette'
                        ]
                    ],
                ],
            ], $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'])
        ],
        'media_width' => [
            'label' => 'LLL:EXT:responsive_picture/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.media_width',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:responsive_picture/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.media_width.desktop', '(min-width: 1200px)'],
                    ['LLL:EXT:responsive_picture/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.media_width.tablet', '(min-width: 768px)'],
                    ['LLL:EXT:responsive_picture/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.media_width.mobile', '(min-width: 300px)'],
                ],
            ]
        ],
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_file_reference', $newColumns);
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('sys_file_reference', 'imageoverlayPalette','--linebreak--,picture_variants', 'after:crop');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('sys_file_reference', 'variantsPalette','media_width', 'after:title');
});
