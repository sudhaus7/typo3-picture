<?php

namespace SUDHAUS7\TestSite\Controller;

use Psr\Http\Message\ResponseInterface;
use DateTime;

use function strip_tags;

use SUDHAUS7\Guard7\Tools\AddLoggedInFrontendUserPublicKeySingleton;
use SUDHAUS7\TestSite\Domain\Model\Blog;
use SUDHAUS7\TestSite\Domain\Model\Comment;
use SUDHAUS7\TestSite\Domain\Repository\BlogRepository;
use SUDHAUS7\TestSite\Domain\Repository\CommentRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class DetailController extends ActionController
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

    public function detailAction(Blog $blog): ResponseInterface
    {
        $newcomment = new Comment();

        $this->view->assignMultiple([
            'blog' => $blog,
            'comments' => $this->commentRepository->findBy(['blog' => $blog]),
            'newcomment' => $newcomment,
        ]);
        return $this->htmlResponse();
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
        $comment->setComment(strip_tags((string) $comment->getComment()));
        $comment->setCommentor(strip_tags((string) $comment->getCommentor()));

        if ($GLOBALS['TSFE']->loginUser) {
            $encodeStorage = GeneralUtility::makeInstance(AddLoggedInFrontendUserPublicKeySingleton::class);
            $encodeStorage->add($comment);
        }

        $this->commentRepository->add($comment);
        return $this->redirect('detail', null, null, ['blog' => $comment->getBlog()]);
    }
}
