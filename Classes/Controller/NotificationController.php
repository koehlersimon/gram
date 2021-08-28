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

        $output['notifications'] = [
            [
                "username" => "henry_maske_78",
                "avatar" => "https://via.placeholder.com/40x40",
                "message" => "liked your video",
                "time" => "33m"
            ],
            [
                "username" => "Thomas Schmidt",
                "avatar" => "https://via.placeholder.com/40x40",
                "message" => "liked your video",
                "time" => "5d"
            ],
            [
                "username" => "BunnyHop78",
                "avatar" => "https://via.placeholder.com/40x40",
                "message" => "liked your video",
                "time" => "3w"
            ]
        ];

        $this->view->assign('json',json_encode($output));

    }


}
