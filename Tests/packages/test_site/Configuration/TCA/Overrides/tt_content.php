<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

call_user_func(function () {
    ExtensionUtility::registerPlugin(
        'SUDHAUS7.TestSite',
        'List',
        'Workshop Blog List',
        'EXT:test_site/Resources/Public/Icons/Extension.svg'
    );
    ExtensionUtility::registerPlugin(
        'SUDHAUS7.TestSite',
        'Latest',
        'Workshop Blog Latest',
        'EXT:test_site/Resources/Public/Icons/Extension.svg'
    );
    ExtensionUtility::registerPlugin(
        'SUDHAUS7.TestSite',
        'Detail',
        'Workshop Blog Detail',
        'EXT:test_site/Resources/Public/Icons/Extension.svg'
    );
    
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['workshopblog_list'] = 'pi_flexform';
    ExtensionManagementUtility::addPiFlexFormValue('workshopblog_list', 'FILE:EXT:test_site/Configuration/Flexforms/Flexform.xml');
    
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['workshopblog_latest'] = 'pi_flexform';
    ExtensionManagementUtility::addPiFlexFormValue('workshopblog_latest', 'FILE:EXT:test_site/Configuration/Flexforms/Flexform.xml');
});
