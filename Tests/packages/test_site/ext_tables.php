<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addPageTSConfig('
tx_sudhaus7guard7 {
    tx_workshopblog_domain_model_comment {
        fields = commentor,comment
    }
}
');
