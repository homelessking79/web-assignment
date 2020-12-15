<?php 

require_once '../background/_DbOperations.php';
require_once '../background/_Response.php';
require_once '../background/_validator.php';

	$responseObj = null;
	
	if($_SERVER['REQUEST_METHOD']=='POST'){	

		if(isset($_POST['id'])){
			$dbOperationsObject = new DbOperations(); 
			$res = $dbOperationsObject->deleteCategory($_POST['id']);
			if($res){
				if($responseObj == null){
					$responseObj = new Response();
				}
				$responseObj->setError(false);	
				$responseObj->setMessage('Category deleted');	
				echo $responseObj->getResponse();
				exit();
			}else{
				if($responseObj == null){
					$responseObj = new Response();
				}
				$responseObj->setError(true);	
				$responseObj->setMessage('Error while deleting the Category');	
				echo $responseObj->getResponse();
				exit();
			}
		}else{
			if($responseObj == null){
				$responseObj = new Response();
			}
			$responseObj->setError(true);	
			$responseObj->setMessage('Parameter missing');	
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