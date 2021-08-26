<?php
namespace SIMONKOEHLER\Gram\DataProcessing;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

class DataProcessor implements DataProcessorInterface
{
   public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
        print_r($processedData['data']);
       $processedData['data']['myNewField'] = 'myValue';
       return $processedData;
    }
}
