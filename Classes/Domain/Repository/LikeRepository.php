<?php
namespace SIMONKOEHLER\Osp\Domain\Repository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\DataHandling\DataHandler;

class LikeRepository extends \TYPO3\CMS\Extbase\Persistence\Repository{

    public function getLikesFromPost($user,$record){

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_osp_domain_model_like');
        $count = $queryBuilder
           ->count('uid')
           ->from('tx_osp_domain_model_like')
           ->where(
              $queryBuilder->expr()->eq('owner',$queryBuilder->createNamedParameter($user, \PDO::PARAM_INT))
            )
            ->andWhere(
              $queryBuilder->expr()->eq('parent',$queryBuilder->createNamedParameter($record, \PDO::PARAM_INT))
           )
           ->execute()
           ->fetchColumn(0);

         return $count;

    }

}
