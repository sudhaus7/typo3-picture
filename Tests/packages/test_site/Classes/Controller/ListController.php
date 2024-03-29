<?php

namespace SUDHAUS7\TestSite\Controller;

use SUDHAUS7\TestSite\Domain\Repository\BlogRepository;
use SUDHAUS7\TestSite\Domain\Repository\CommentRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ListController extends ActionController
{
    /**
     * @var BlogRepository
     */
    protected $blogRepository;

    /**
     * @var CommentRepository
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
            'blogs'=>$this->blogRepository->findAll(),
        ]);
    }
}
