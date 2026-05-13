<?php

use SUDHAUS7\TestSite\Controller\ListController;
use SUDHAUS7\TestSite\Controller\LatestController;
use SUDHAUS7\TestSite\Controller\DetailController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

if (!defined('TYPO3')) {
    die();
}

ExtensionUtility::configurePlugin(
    'TestSite',
    'List',
    [
        ListController::class => 'index',
    ],
    [
        ListController::class => 'index',
    ]
);
ExtensionUtility::configurePlugin(
    'TestSite',
    'Latest',
    [
        LatestController::class => 'index',
    ],
    [
        LatestController::class => 'index',
    ]
);
ExtensionUtility::configurePlugin(
    'TestSite',
    'Detail',
    [

        DetailController::class => 'detail,savecomment',
    ],
    [

        DetailController::class => 'detail,savecomment',
    ]
);
