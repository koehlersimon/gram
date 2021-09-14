<?php
namespace SIMONKOEHLER\Gram\Controller;
use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;

/**
 * MessageController
 */
class InboxController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * @var FrontendUserRepository
     */
    private $frontendUserRepository;


    /**
     * @param FrontendUserRepository $frontendUserRepository
     */
    public function injectFrontendUserRepository(FrontendUserRepository $frontendUserRepository){
        $this->frontendUserRepository = $frontendUserRepository;
    }

    /**
     * action inbox
     *
     * @return void
     */
    public function interfaceAction(){
        $fe_user = $this->frontendUserRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);
        $this->view->assign('user',$fe_user);
        $this->view->assign('settings',$this->settings);
    }

    /**
     * action inbox
     *
     * @return void
     */
    public function chatAction(){
        $this->view->assign('chat','demo...');
    }


}
