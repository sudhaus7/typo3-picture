<?php


namespace SUDHAUS7\TestSite\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class BlogRepository extends Repository
{
    protected $defaultOrderings = array(
        'date' => QueryInterface::ORDER_DESCENDING
    );
}
