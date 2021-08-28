<?php
namespace SIMONKOEHLER\Gram\Controller;
use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Backend\Utility\BackendUtility;

/**
 * NotificationController
 */
class NotificationController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * likeRepository
     *
     * @var \SIMONKOEHLER\Gram\Domain\Repository\NotificationRepository
     * @Inject
     */
    protected $notificationRepository = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @Inject
     */
    protected $persistenceManager;

    /**
     * action list
     *
     * @return void
     */
    public function listAction(){

        $output['msg'] = 'No access';
        $output['label'] = '<i class=\"fa fa-love\"></i> No access!';

        $this->view->assign('json',json_encode($output));

    }


}
