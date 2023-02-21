<?php

use SUDHAUS7\TestSite\Domain\Model\Blog;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

if (!defined('TYPO3_MODE')) {
    die();
}

ExtensionUtility::configurePlugin(
    'SUDHAUS7.TestSite',
    'List',
    [
        'List' => 'index',
    ],
    [
        'List' => 'index',
    ],
    ExtensionUtility::PLUGIN_TYPE_PLUGIN
);
ExtensionUtility::configurePlugin(
    'SUDHAUS7.TestSite',
    'Latest',
    [
        'Latest'=>'index',
    ],
    [
        'Latest'=>'index',
    ],
    ExtensionUtility::PLUGIN_TYPE_PLUGIN
);
ExtensionUtility::configurePlugin(
    'SUDHAUS7.TestSite',
    'Detail',
    [

        'Detail'=>'detail,savecomment'
    ],
    [

        'Detail'=>'detail,savecomment'
    ],
    ExtensionUtility::PLUGIN_TYPE_PLUGIN
);

