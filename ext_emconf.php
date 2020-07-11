<?php

$EM_CONF[$_EXTKEY] = [
    'title' => '(Sudhaus7) Responsive Picture',
    'description' => 'Adds media variations to the Image / FileReference Element, automatically creates media variations and allows to define different images and crop-configurations per media query',
    'category' => 'fe',
    'version' => '1.0.0',
    'state' => 'stable',
    'createDirs' => '',
    'upload_folder' => false,
    'clearcacheonload' => 0,
    'author' => 'Markus Hofmann & Frank Berger',
    'author_email' => 'fberger@sudhaus7.de',
    'author_company' => 'Sudhaus7, a B-Factor GmbH label https://sudhaus7.de/',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.4.99'
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'SUDHAUS7\\ResponsivePicture\\' => 'Classes'
        ]
    ],
];

