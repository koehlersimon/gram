<?php
namespace SIMONKOEHLER\Osp\Domain\Repository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * The repository for Account
 */

class AccountRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    public function updateUserData($user) {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');
        $statement = $queryBuilder
            ->update('fe_users','u')
            ->where(
                $queryBuilder->expr()->eq('u.uid', $queryBuilder->createNamedParameter($user['uid'], \PDO::PARAM_INT))
            )
            ->set('u.title', $user['title'])
            ->set('u.name', $user['first_name'].' '.$user['last_name'])
            ->set('u.first_name', $user['first_name'])
            ->set('u.middle_name', $user['middle_name'])
            ->set('u.last_name', $user['last_name'])
            ->set('u.email', $user['email'])
            ->set('u.company', $user['company'])
            ->set('u.address', $user['address'])
            ->set('u.zip', $user['zip'])
            ->set('u.city', $user['city'])
            ->set('u.country', $user['country'])
            ->set('u.telephone', $user['telephone']);

        if($user['usernameUnique']){
            $statement->set('u.username', $user['usernameUnique']);
        }

        if($user['passwordNewHashed']){
            $statement->set('u.password', $user['passwordNewHashed']);
        }

        $statement->execute();
        return $user;
    }


    public function deleteAccount($uid) {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');
        $statement = $queryBuilder
            ->delete('fe_users')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT))
            )
            ->execute();
        return $statement;
    }


    public function usernameExists($username) {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');
        $count = $queryBuilder
           ->count('username')
           ->from('fe_users')
           ->where(
              $queryBuilder->expr()->eq('username', $queryBuilder->createNamedParameter($username))
           )
           ->execute()
           ->fetchColumn(0);
        return $count;
    }

    private function getTranslation($key){
        return \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($key,'osp');
    }

}
