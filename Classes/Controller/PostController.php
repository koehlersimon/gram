<?php
namespace SIMONKOEHLER\Gram\Controller;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\TypoScript\Parser\ConstantConfigurationParser;

/**
 * PostController
 */
class PostController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * Protected Variable FrontendUserRepository wird mit NULL initialisiert.
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @Inject
     */
    protected $frontendUserRepository = NULL;

    /**
     * postRepository
     *
     * @var \SIMONKOEHLER\Gram\Domain\Repository\PostRepository
     * @Inject
     */
    protected $postRepository = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @Inject
     */
    protected $persistenceManager;

    /**
     * @var \TYPO3\CMS\Core\TypoScript\Parser\ConstantConfigurationParser
     */
    private $configurationParser;


    public function __construct(ConstantConfigurationParser $configurationParser = null){
        $this->configurationParser = $configurationParser ?? GeneralUtility::makeInstance(ConstantConfigurationParser::class);
    }

    /**
     * action listAjaxAction
     *
     * @return void
     */
    public function galleryDataAction(){
        //$fe_user = $this->frontendUserRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);
        //$this->view->assign('fe_user', $fe_user);
        $this->view->assign('settings',$this->settings);
        //$this->view->assign('posts',$this->postRepository->findAll());
    }

    /**
     * action listUser
     *
     * @return void
     */
    public function listUserAction(){
        $fe_user = $this->frontendUserRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);
        $this->view->assign('fe_user', $fe_user);
        $this->view->assign('settings',$this->settings);
        $this->view->assign('posts',$this->postRepository->findByOwner($GLOBALS['TSFE']->fe_user->user['uid']));
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction(){
        // Assign the results as variables to fluid template
        $this->view->assignMultiple([
            'fe_user' => $fe_user,
            'settings' => $this->settings,
            'posts' => $this->postRepository->findAll()
        ]);
    }

    /**
     * action list
     *
     * @return void
     */
    public function backendListAction(){
        $this->view->assign('posts',$this->postRepository->findAll());
    }

    /**
     * action preview
     *
     * @return void
     */
    public function previewAction(){
        $args = $this->request->getArguments();
        $args['bodytext'] = $_POST['bodytext'];
        $this->view->assign('args',$args);
    }

    /**
     * action detail
     *
     * @return void
     */
    public function detailAction(){
        if($this->request->hasArgument('post')){
            $this->view->assign('post', $this->postRepository->findByUid($this->request->getArgument('post')));
        }
    }

    /**
     * action fetch
     *
     * @return void
     */
    public function fetchAction(){

        // Get Url from post owner fe_user record
        if($this->request->hasArgument('owner')){
            $owner = $this->postRepository->frontendUserApiUrl($this->request->getArgument('owner'));
            $apiBaseUrl = $owner['gram_url'];
        }
        else{
            $apiBaseUrl = $this->settings['site']['absRefPrefix'];
        }

        if($this->request->hasArgument('post')){
            $url = $apiBaseUrl.'?type='.$this->settings['pages']['types']['page_external_post_provide'].'&tx_gram_post[post]='.$this->request->getArgument('post');
            $get_data = $this->postRepository->callAPI('GET', $url, false);
            $post = json_decode($get_data);
            if($post){
                $output = $post;
            }
            else{
                $output['content'] = 'p(badge bg-danger p-4). Post data could not be fetched!<br>('.$url.')';
            }
        }
        else{
            $output['content'] = 'p(badge bg-danger). No post ID given!';
        }

        $this->view->assign('post', $output);

    }

    /**
     * action provide
     * This action provides JSON content of a post
     * It must be called with the page type 910 and a post ID of an external post
     *
     * @return void
     */
    public function provideAction(){
        if($this->request->hasArgument('post')){
            $post = $this->postRepository->findByUid($this->request->getArgument('post'));
            if($post){
                $array['uid'] = $this->request->getArgument('post');
                $array['content'] = $post->getContent();
                $array['crdate'] = $post->getCrdate();
                $array['owner'] = $post->getOwner();
                $this->view->assign('dataJson',json_encode($array));
            }
            else{
                $this->view->assign('dataJson',json_encode(['content' => '<div class="alert alert-warning">Post ('.$this->request->getArgument('post').') is not accessible or could not be loaded!</div>']));
            }
        }
        else{
            $this->view->assign('dataJson',json_encode(['content' => '<div class="alert alert-danger">No post ID given!</div>']));
        }
    }

    /**
     * action form
     *
     * @return void
     */
    public function formAction(){

        if($this->request->hasArgument('content')){
            if(strlen($this->request->getArgument('content')) > 0){

                // Set static value for the fe_group value to prevent users to set another value here!
                if($this->request->hasArgument('privacy')){
                    switch ($this->request->getArgument('privacy')) {
                        case '0':
                            $feGroup = '0';
                            $hidden = 0;
                            break;
                        case '1':
                            $feGroup = '-2';
                            $hidden = 1;
                            break;
                        default:
                            $feGroup = '-2';
                            $hidden = 0;
                            break;
                    }
                }
                else{
                    $feGroup = '-2';
                    $hidden = 0;
                }

                $owner = $this->frontendUserRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);

                // Create new post record
                $newPost = new \SIMONKOEHLER\Gram\Domain\Model\Post();
                $newPost->setFeGroup($feGroup);
                $newPost->setHidden($hidden);
                $newPost->setLikes(0);
                $newPost->setOwner($owner);
                $newPost->setContent($this->request->getArgument('content'));
                $this->postRepository->add($newPost);
                $this->persistenceManager->persistAll();

                // Create file reference for post record
                $uploadedFiles = $this->request->getArgument('files');

                if(count($uploadedFiles) > 0){
                    foreach ($uploadedFiles as $file) {
                        if($file['tmp_name'] !== '' && $file['name'] !== ''){
                            $newFile = $this->postRepository->createFileObject($file['tmp_name'],$file['name'],$this->settings['storage']['media']);
                            $this->postRepository->createFileReference($newFile->getProperties()['uid'],$newPost->getUid(),$newPost->getPid(),'tx_gram_domain_model_post','media');
                        }
                    }
                }

                $this->addFlashMessage(
                   $messageBody = 'Your post has been saved',
                   $messageTitle = 'Yeah',
                   $severity = \TYPO3\CMS\Core\Messaging\AbstractMessage::OK,
                   $storeInSession = TRUE
                );

                $uriBuilder = $this->uriBuilder;
                $uri = $uriBuilder
                  ->setTargetPageUid($this->settings['pages']['post']['form'])
                  ->build();
                $this->redirectToUri($uri, 1, 303);

            }
            else{
                $this->addFlashMessage("Well, that's too little!");
            }
        }
        $this->view->assign('fe_user',$GLOBALS['TSFE']->fe_user->user);
    }

    /**
     * action delete
     *
     * @return void
     */
    public function deleteAction(\SIMONKOEHLER\Gram\Domain\Model\Post $post){

        $this->postRepository->remove($post);

        $this->addFlashMessage(
           $messageBody = 'You can recover this post in the backend by using the recycler module.',
           $messageTitle = 'Post #'.$post->getUid().' deleted!',
           $severity = \TYPO3\CMS\Core\Messaging\AbstractMessage::OK,
           $storeInSession = TRUE
        );

        $uriBuilder = $this->uriBuilder;
        $uri = $uriBuilder
          ->setTargetPageUid($this->settings['pages']['post']['form'])
          ->build();
        $this->redirectToUri($uri, 1, 303);

    }


    /**
     * action edit
     *
     * @return void
     */
    public function editAction(){
        if($this->request->hasArgument('post')){
            $this->view->assign('post', $this->postRepository->findByUid($this->request->getArgument('post')));
        }
    }


    /**
     * action update
     *
     * @return void
     */
    public function updateAction(\SIMONKOEHLER\Gram\Domain\Model\Post $post){
        $post->setContent($this->request->getArgument('content'));
        $this->postRepository->update($post);

        $this->addFlashMessage(
           $messageBody = '',
           $messageTitle = 'Post #'.$post->getUid().' updated!',
           $severity = \TYPO3\CMS\Core\Messaging\AbstractMessage::OK,
           $storeInSession = TRUE
        );

        $uriBuilder = $this->uriBuilder;
        $uri = $uriBuilder
          ->setTargetPageUid($this->settings['pages']['post']['form'])
          ->build();
        $this->redirectToUri($uri, 1, 303);
    }


}
