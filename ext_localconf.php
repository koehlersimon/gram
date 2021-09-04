<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\CMS\Extbase\Domain\Model\FrontendUser'] = array(
            'className' => 'SIMONKOEHLER\Gram\Domain\Model\User'
        );

        $icons = [
            'modals-button' => 'EXT:gram/Resources/Public/Icons/ContentElements/window-maximize.svg'
        ];

        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
        foreach ($icons as $identifier => $path) {
            $iconRegistry->registerIcon(
                $identifier,
                \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                ['source' => $path]
            );
        }

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
          'Gram',
          'Explore',
          [
             \SIMONKOEHLER\Gram\Controller\PostController::class => 'explore',
          ],
          // non-cacheable actions
          [
             \SIMONKOEHLER\Gram\Controller\PostController::class => '',
          ]
       );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
          'Gram',
          'Gallery',
          [
             \SIMONKOEHLER\Gram\Controller\PostController::class => 'list,galleryData',
          ],
          // non-cacheable actions
          [
             \SIMONKOEHLER\Gram\Controller\PostController::class => '',
          ]
       );

       \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
         'Gram',
         'Notifications',
         [
            \SIMONKOEHLER\Gram\Controller\NotificationController::class => 'list',
         ],
         // non-cacheable actions
         [
            \SIMONKOEHLER\Gram\Controller\NotificationController::class => '',
         ]
      );

      \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Gram',
        'Inbox',
        [
           \SIMONKOEHLER\Gram\Controller\MessageController::class => 'inbox',
        ],
        // non-cacheable actions
        [
           \SIMONKOEHLER\Gram\Controller\MessageController::class => '',
        ]
     );

    // Add default RTE configuration
    //$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['eleganz'] = 'EXT:eleganz/Configuration/RTE/Default.yaml';

    }
);
