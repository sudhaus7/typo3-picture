<?php


namespace SUDHAUS7\TestSite\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use SUDHAUS7\TestSite\Domain\Repository\BlogRepository;
use SUDHAUS7\TestSite\Domain\Repository\CommentRepository;

class LatestController extends ActionController
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
    
    public function indexAction()
    {
        $this->view->assignMultiple([
            'blogs'=>$this->blogRepository->findAll()->getQuery()->setLimit(3)->execute(),
        ]);
    }
}
