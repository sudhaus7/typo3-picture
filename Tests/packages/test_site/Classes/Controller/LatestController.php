<?php

namespace SUDHAUS7\TestSite\Controller;

use Psr\Http\Message\ResponseInterface;
use SUDHAUS7\TestSite\Domain\Repository\BlogRepository;
use SUDHAUS7\TestSite\Domain\Repository\CommentRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class LatestController extends ActionController
{
    /**
     * @var BlogRepository
     */
    protected $blogRepository;

    /**
     * @var CommentRepository
     */
    protected $commentRepository;
    public function __construct(BlogRepository $blogRepository, CommentRepository $commentRepository)
    {
        $this->blogRepository = $blogRepository;
        $this->commentRepository = $commentRepository;
    }

    public function indexAction(): ResponseInterface
    {
        $this->view->assignMultiple([
            'blogs' => $this->blogRepository->findAll()->getQuery()->setLimit(3)->execute(),
        ]);
        return $this->htmlResponse();
    }
}
