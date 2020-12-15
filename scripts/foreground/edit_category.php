<?php 

require_once '../background/_DbOperations.php';
require_once '../background/_Response.php';
require_once '../background/_validator.php';

	$responseObj = null;

	if($_SERVER['REQUEST_METHOD']=='POST'){	

		if(isset($_POST['cat']) && isset($_POST['id'])){
			
			
			if(empty(trim($_POST['cat'])) ){
				if($responseObj == null){
					$responseObj = new Response();
				}
				if(!$responseObj->getError()){
					$responseObj->setError(true);
				}
				$responseObj->setMessage('Please provide the category name');
				echo $responseObj->getResponse();
				exit();
			}

			// if (!validator::isValidName(trim($_POST['cat']))){
			// 	if($responseObj == null){
			// 		$responseObj = new Response();
			// 	}
			// 	if(!$responseObj->getError()){
			// 		$responseObj->setError(true);
			// 	}
			// 	$responseObj->setMessage('Please provide the valid category name');	
			// 	echo $responseObj->getResponse();
			// 	exit();				
			// }
			
			
			$dbOperationsObject = new DbOperations(); 
			$responseObj = $dbOperationsObject->updateCategory(trim($_POST['cat']) , trim($_POST['id']));
			echo $responseObj->getResponse();
			exit();
		}else{
			if($responseObj == null){
				$responseObj = new Response();
			}
			$responseObj->setError(true);	
			$responseObj->setMessage('Required parameters are missing');	
			echo $responseObj->getResponse();
			exit();
		}
	
	}else{
		if($responseObj == null){
			$responseObj = new Response();
		}
		$responseObj->setError(true);	
		$responseObj->setMessage('Invalid Request');	
		echo $responseObj->getResponse();
		exit();
	}
	
?>