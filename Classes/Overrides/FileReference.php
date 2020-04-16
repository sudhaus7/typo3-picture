<?php


namespace SUDHAUS7\ResponsivePicture\Overrides;

use PDO;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Resource\FileCollector;

/**
 * Class FileReference
 *
 * @package SUDHAUS7\Picture\Overrides
 */
class FileReference extends \TYPO3\CMS\Core\Resource\FileReference
{

    /**
     * @var null|array
     */
    protected $variants = null;
    
    /**
     * @var ResourceFactory
     */
    private $factory;
    
    /**
     * FileReference constructor.
     *
     * @param array $fileReferenceData
     * @param null $factory
     */
    public function __construct(array $fileReferenceData, $factory = null)
    {
        parent::__construct($fileReferenceData, $factory);
        $this->factory = GeneralUtility::makeInstance(ResourceFactory::class);
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

            $db = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file_reference');

            $result = $db->select('*')
                ->from('sys_file_reference')
                ->where(
                    $db->expr()->andX(...[
                        $db->expr()->eq('uid_foreign', $properties['uid']),
                        $db->expr()->eq('tablenames', $db->quote('sys_file_reference')),
                        $db->expr()->eq('fieldname', $db->quote('picture_variants')),
                    ])
                )
                ->orderBy('sorting_foreign')
                ->execute();
            
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                //$uids[]=$row['uid'];
                $this->variants[] = $this->factory->getFileReferenceObject($row['uid'],$row);
                
            }
            
        }
        return $this->variants;
    }
}
