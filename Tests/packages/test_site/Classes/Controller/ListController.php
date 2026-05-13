<?php

declare(strict_types=1);

namespace SUDHAUS7\TestSite\Controller;

use Psr\Http\Message\ResponseInterface;
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
    public function __construct(BlogRepository $blogRepository, CommentRepository $commentRepository)
    {
        $this->blogRepository = $blogRepository;
        $this->commentRepository = $commentRepository;
    }

    public function indexAction(): ResponseInterface
    {
        $this->view->assignMultiple([
            'blogs' => $this->blogRepository->findAll(),
        ]);
        return $this->htmlResponse();
    }
}
