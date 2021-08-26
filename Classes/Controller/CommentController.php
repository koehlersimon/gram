<?php
namespace SIMONKOEHLER\Gram\Controller;
use TYPO3\CMS\Extbase\Annotation\Inject;

/**
 * CommentController
 */
class CommentController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * Protected Variable FrontendUserRepository wird mit NULL initialisiert.
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @Inject
     */
    protected $frontendUserRepository = NULL;

    /**
     * commentRepository
     *
     * @var \SIMONKOEHLER\Gram\Domain\Repository\CommentRepository
     * @Inject
     */
    protected $commentRepository = NULL;

    /**
     * action list
     *
     * @return void
     */
    public function listAction(){
        $this->view->assign('settings',$this->settings);
        $this->view->assign('comments',$this->commentRepository->findAll());
    }

    /**
     * action post
     *
     * @return void
     */
    public function postAction(){
        $this->view->assign('settings',$this->settings);
    }

    /**
     * action form
     *
     * @return void
     */
    public function formAction(){
        if($this->request->hasArgument('content')){
            if(strlen($this->request->getArgument('content')) > 0){
                $newComment = new \SIMONKOEHLER\Gram\Domain\Model\Comment();
                $newComment->setContent($this->request->getArgument('content'));
                $this->commentRepository->add($newComment);
            }
            else{
                $this->addFlashMessage("Well, that's too little!");
            }
        }
        $user = $this->frontendUserRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);
        $this->view->assign('fe_user', $user);
    }

    /**
     * action delete
     *
     * @return void
     */
    public function deleteAction(\SIMONKOEHLER\Gram\Domain\Model\Comment $comment){
        $this->commentRepository->remove($comment);
        $this->addFlashMessage('comment deleted!');
    }


    /**
     * action edit
     *
     * @return void
     */
    public function editAction(){
        if($this->request->hasArgument('comment')){
            $this->view->assign('comment', $this->commentRepository->findByUid($this->request->getArgument('comment')));
        }
    }


    /**
     * action update
     *
     * @return void
     */
    public function updateAction(\SIMONKOEHLER\Gram\Domain\Model\Comment $comment){
        $comment->setContent($this->request->getArgument('content'));
        $this->commentRepository->update($comment);
        $this->addFlashMessage('Comment updated!');
    }

}
