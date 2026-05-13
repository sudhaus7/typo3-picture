<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

call_user_func(function (): void {
    ExtensionUtility::registerPlugin(
        'TestSite',
        'List',
        'Workshop Blog List',
        'EXT:test_site/Resources/Public/Icons/Extension.svg'
    );
    ExtensionUtility::registerPlugin(
        'TestSite',
        'Latest',
        'Workshop Blog Latest',
        'EXT:test_site/Resources/Public/Icons/Extension.svg'
    );
    ExtensionUtility::registerPlugin(
        'TestSite',
        'Detail',
        'Workshop Blog Detail',
        'EXT:test_site/Resources/Public/Icons/Extension.svg'
    );

    ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,', 'workshopblog_list', 'after:subheader');
    ExtensionManagementUtility::addPiFlexFormValue('*', 'FILE:EXT:test_site/Configuration/Flexforms/Flexform.xml', 'workshopblog_list');

    ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,', 'workshopblog_latest', 'after:subheader');
    ExtensionManagementUtility::addPiFlexFormValue('*', 'FILE:EXT:test_site/Configuration/Flexforms/Flexform.xml', 'workshopblog_latest');
});
