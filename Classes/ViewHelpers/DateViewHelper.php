<?php
namespace SIMONKOEHLER\Gram\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DateViewHelper extends AbstractViewHelper {

    use CompileWithRenderStatic;

    public function initializeArguments(){
       $this->registerArgument('content', 'string', 'The content to parse', true);
    }

   public static function renderStatic(
       array $arguments,
       \Closure $renderChildrenClosure,
       RenderingContextInterface $renderingContext
   ) {
       $date = new \DateTime();
       $date->setTimestamp($arguments['content']);
       $now = time();
       if($arguments['content'] < $now){
           $minutes = ($now - $arguments['content'])/60;
           $hours = round($minutes/60);
           $weeks = round($hours/168);

           if($minutes < 2){
               $result = round($minutes).' minute ago';
           }
           elseif($minutes < 60){
               $result = round($minutes).' minutes ago';
           }
           elseif($hours > 0 && $hours < 2){
               $result = $hours.' hour ago';
           }
           elseif($hours > 1 && $hours < 24){
               $result = $hours.' hours ago';
           }
           elseif($hours > 24 && $hours < 48){
               $result = round($hours/24).' day ago';
           }
           elseif($hours > 48 && $hours < 168){
               $result = round($hours/24).' days ago';
           }
           elseif($hours > 168 && $hours < 336){
              $result = $weeks.' week ago';
           }
           elseif($hours > 336){
              $result = $weeks.' weeks ago';
           }

       }
       return $result;
   }

}
