<?php


namespace SUDHAUS7\Picture\Overrides;

use PDO;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\Resource\FileCollector;

class FileReference extends \TYPO3\CMS\Core\Resource\FileReference
{

    /**
     * @var null|array
     */
    protected $variants = null;

    public function __construct(array $fileReferenceData, $factory = null)
    {
        parent::__construct($fileReferenceData, $factory);
        $this->getVariants();
    }

    /**
     * @return array
     */
    public function getVariants(): array
    {
        if ($this->variants === null) {
            $this->variants = [];

            $fileCollector = GeneralUtility::makeInstance(FileCollector::class);
            $properties = $this->getProperties();
            $om = GeneralUtility::makeInstance(ObjectManager::class);
            $db = $om->get(ConnectionPool::class)->getQueryBuilderForTable('sys_file_reference');

            $result = $db->select('*')
                ->from('sys_file_reference')
                ->where(
                    $db->expr()->andX(...[
                        $db->expr()->eq('uid_foreign', $properties['uid']),
                        $db->expr()->eq('tablenames', $db->quote('sys_file_reference'))
                    ])
                )
                ->orderBy('sorting_foreign')
                ->execute();
            $uids = [];
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $uids[]=$row['uid'];
            }
            if (!empty($uids)) {
                $fileCollector->addFileReferences($uids);
                $this->variants = $fileCollector->getFiles();
            }
        }

        return $this->variants;
    }
}
