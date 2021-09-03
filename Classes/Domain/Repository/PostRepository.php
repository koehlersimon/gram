<?php
namespace SIMONKOEHLER\Gram\Domain\Repository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

class PostRepository extends \TYPO3\CMS\Extbase\Persistence\Repository{

    // Order by BE sorting
	protected $defaultOrderings = array(
		'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
	);

	// Example for repository wide settings
   public function initializeObject() {
      /** @var Typo3QuerySettings $querySettings */
      $querySettings = new Typo3QuerySettings();

      // don't add the pid constraint
      $querySettings->setRespectStoragePage(false);
      // set the storagePids to respect
      // $querySettings->setStoragePageIds(array(1, 26, 989));

      // define the enablecolumn fields to be ignored, true ignores all of them
      //$querySettings->setIgnoreEnableFields(TRUE);

      // define single fields to be ignored
      // $querySettings->setEnableFieldsToBeIgnored(array('disabled','starttime'));

      // add deleted rows to the result
      // $querySettings->setIncludeDeleted(TRUE);

      // don't add sys_language_uid constraint
      // $querySettings->setRespectSysLanguage(FALSE);

      $this->setDefaultQuerySettings($querySettings);
   }

	public function findAllAjax(){
		$query = $this->createQuery();
	    $query->setLimit(5);
	    return $query->execute();
	}

	public function findByOwner($owner){
		$query = $this->createQuery();
		$query->getQuerySettings()->setIgnoreEnableFields(true);
		$query->matching($query->contains('owner', $owner));
	    return $query->execute();
	}

	// Moves the file from $tmpName to the default storage of the user and names it like $fileName
	public function createFileObject($tmpName,$fileName,$storage){

		// Get instance of the ResourceFactory class
		$resourceFactory = ResourceFactory::getInstance();

		// If no storage
		if(!$storage){
			$storageObject = $resourceFactory->getDefaultStorage();
		}
		else{
			$storageObject = $resourceFactory->getStorageObject($storage);
		}

		// Add the file
		$newFile = $storageObject->addFile(
			  $tmpName,
			  $storageObject->getRootLevelFolder(),
			  $fileName
		);
		// Send the file object back to the controller
		return $newFile;

	}

	/*
	* Creates a file reference for any kind of record!
	* $file 			UID of file object
	* $record 			UID or parent record
	* $pid 				PID of the parent record
	* $tablenames 		Name of the table, for instance "tt_content"
	* $fieldname		Name of the reference field in the parent record
	*/
	public function createFileReference($file,$record,$pid,$tablenames,$fieldname){

		// Create sys_refindex entry manually
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_refindex');
		$affectedRows = $queryBuilder
		   ->insert('sys_refindex')
		   ->values([
				'hash' => md5($file),
				'tablename' => $tablenames,
				'recuid' => $record,
				'ref_table' => 'sys_file_reference',
				'ref_uid' => $file,
				'field' => $fieldname,
		   ])
		   ->execute();

		// Create sys_file_reference entry manually
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file_reference');
   		$affectedRows = $queryBuilder
   		   ->insert('sys_file_reference')
   		   ->values([
   		      'pid' => $pid,
   		      'tstamp' => time(),
   		      'crdate' => time(),
   		      'uid_local' => $file,
   		      'uid_foreign' => $record,
   		      'tablenames' => $tablenames,
   		      'fieldname' => $fieldname,
			  'table_local' => 'sys_file',
   		   ])
   		   ->execute();

	}


	/*
	* Creates a file reference for any kind of record!
	*/
	public function frontendUserApiUrl($fe_user_uid){

		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');
		$statement = $queryBuilder
		   ->select('uid', 'tx_gram_url')
		   ->from('fe_users')
		   ->where(
		      $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($fe_user_uid, \PDO::PARAM_INT))
		   )
		   ->execute();
		while ($row = $statement->fetch()) {
		   return $row;
	 	}

	}

	public function callAPI($method, $url, $data){
	   $curl = curl_init();
	   switch ($method){
	      case "POST":
	         curl_setopt($curl, CURLOPT_POST, 1);
	         if ($data)
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	         break;
	      case "PUT":
	         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
	         if ($data)
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	         break;
	      default:
	         if ($data)
	            $url = sprintf("%s?%s", $url, http_build_query($data));
	   }
	   // OPTIONS:
	   curl_setopt($curl, CURLOPT_URL, $url);
	   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	      'APIKEY: 111111111111111111111',
	      'Content-Type: application/json',
	   ));
	   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	   // EXECUTE:
	   $result = curl_exec($curl);
	   if(!$result){die("Connection Failure (Failed to connect to: ".$url.")");}
	   curl_close($curl);
	   return $result;
	}

}
