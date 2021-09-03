<?php
declare(strict_types=1);
namespace SIMONKOEHLER\Gram\Widgets;

use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Dashboard\Widgets\AdditionalCssInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetConfigurationInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Reports\Status as ReportStatus;

class FrontendUserWidget implements WidgetInterface, AdditionalCssInterface
{
    /**
     * @var WidgetConfigurationInterface
     */
    private $configuration;
    /**
     * @var StandaloneView
     */
    private $view;
    /**
     * @var null
     */
    private $buttonProvider;
    /**
     * @var array
     */
    private $options;

    public function __construct(
        WidgetConfigurationInterface $configuration,
        StandaloneView $view,
        $buttonProvider = null,
        array $options = []
    ) {
        $this->configuration = $configuration;
        $this->view = $view;
        $this->buttonProvider = $buttonProvider;
        $this->options = array_merge(
            [
                'showErrors' => true,
                'showWarnings' => false
            ],
            $options
        );
    }

    public function renderWidgetContent(): string
    {

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');
        $statement = $queryBuilder
           ->select('*')
           ->from('fe_users')
           ->orderBy('crdate','DESC')
           ->setMaxResults(3)
           ->where(
              $queryBuilder->expr()->eq('deleted',$queryBuilder->createNamedParameter(0, \PDO::PARAM_INT))
           )
           ->execute();

        $this->view->setTemplate('Widget/FrontendUserWidget');
        $this->view->assignMultiple([
            'users' => $statement,
            'options' => $this->options,
            'button' => $this->buttonProvider,
            'configuration' => $this->configuration,
            'dateFormat' => $GLOBALS['TYPO3_CONF_VARS']['SYS']['ddmmyy'],
            'timeFormat' => $GLOBALS['TYPO3_CONF_VARS']['SYS']['hhmm'],
        ]);
        return $this->view->render();
    }

    public function getCssFiles(): array
    {
        return [
            'EXT:gram/Resources/Public/Css/frontendUserWidget.css',
        ];
    }

}
