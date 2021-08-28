<?php

call_user_func(
   function () {

       \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
           'Gram',
           'Gallery',
           'GRAM Gallery',
           'EXT:gram/Resources/Public/Icons/Extension.svg'
       );

       \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
           'Gram',
           'Notifications',
           'GRAM Notifications',
           'EXT:gram/Resources/Public/Icons/Extension.svg'
       );

   }
);
