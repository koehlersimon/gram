<?php
namespace SIMONKOEHLER\Osp\Hook;

use TYPO3\CMS\Backend\Controller\PageLayoutController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class PageHook
{

    /**
     * @var StandaloneView
     */
    protected $view;

    public function render(array $params, PageLayoutController $parentObject)
    {
        $pageinfo = $parentObject->pageinfo;
        /*
        if($pageinfo['media'] == 0) {
            return '';
        }
        */
        $fileRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);
        $fileObjects = $fileRepository->findByRelation('pages', 'media', $pageinfo['uid']);

        //load partial paths info from typoscript
        $this->view = GeneralUtility::makeInstance(StandaloneView::class);
        $this->view->setFormat('html');

        $resourcesPath = 'EXT:osp/Resources/';
        $this->view->setTemplatePathAndFilename($resourcesPath . 'Private/Backend/Templates/PageHook.html');
        $this->view->assign('files', $fileObjects);
        $this->view->assign('page', $parentObject->pageinfo);
        return $this->view->render();
    }

}
