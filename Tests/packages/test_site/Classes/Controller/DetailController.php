<?php


namespace SUDHAUS7\TestSite\Controller;

use DateTime;
use SUDHAUS7\Guard7\Tools\AddLoggedInFrontendUserPublicKeySingleton;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use SUDHAUS7\TestSite\Domain\Model\Blog;
use SUDHAUS7\TestSite\Domain\Model\Comment;
use SUDHAUS7\TestSite\Domain\Repository\BlogRepository;
use SUDHAUS7\TestSite\Domain\Repository\CommentRepository;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
use TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use function strip_tags;

class DetailController extends ActionController
{
    /**
     * @var BlogRepository
     *
     */
    protected $blogRepository;
    
    
    /**
     * @var CommentRepository
     *
     */
    protected $commentRepository;
    
    public function injectBlogRepository(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }
    
    public function injectCommentRepository(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }
    
    
    public function detailAction(Blog $blog)
    {
        $newcomment = new Comment();
        
        $this->view->assignMultiple([
           'blog'=>$blog,
           'comments'=>$this->commentRepository->findByBlog($blog),
           'newcomment'=>$newcomment,
        ]);
    }
    
    
    /**
     * @param Comment $comment
     * @throws StopActionException
     * @throws UnsupportedRequestTypeException
     * @throws IllegalObjectTypeException
     */
    public function savecommentAction(Comment $comment)
    {
        $comment->setDate(new DateTime());
        $comment->setComment(strip_tags($comment->getComment()));
        $comment->setCommentor(strip_tags($comment->getCommentor()));
        
        if ($GLOBALS['TSFE']->loginUser) {
            $encodeStorage = GeneralUtility::makeInstance(AddLoggedInFrontendUserPublicKeySingleton::class);
            $encodeStorage->add($comment);
        }
      
        $this->commentRepository->add($comment);
        $this->redirect('detail', null, null, ['blog'=>$comment->getBlog()]);
    }
}
