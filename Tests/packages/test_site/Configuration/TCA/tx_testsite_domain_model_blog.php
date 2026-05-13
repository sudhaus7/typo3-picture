<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'default_sortby' => 'date DESC',
        'adminOnly' => false,
        'rootLevel' => 0,
        'iconfile' => 'EXT:test_site/Resources/Public/Icons/Extension.svg',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'title' => 'Blogentry',
        'searchFields' => 'hidden,date,title,teaser,bodytext',
    ],
    'palettes' => [],
    'types' => [
        1 => [
            'showitem' => 'hidden,date,title,teaser,bodytext',
        ],
    ],
    'columns' => [
        'tstamp' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'Visible',
            'config' => [
                'type' => 'check',
                //'renderType' => 'checkboxToggle',
                'default' => 1,
                'items' => [
                    [
                        'label' => '',
                        1 => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'title' => [
            'label' => 'Title',
            'config' => [
                'type' => 'input',
            ],
        ],
        'date' => [
            'label' => 'Date',
            'config' => [
                'type' => 'datetime',
            ],
        ],

        'teaser' => [
            'label' => 'Teaser',
            'config' => [
                'type' => 'text',
            ],
        ],

        'bodytext' => [
            'label' => 'Content',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
            ],
        ],

    ],
];
