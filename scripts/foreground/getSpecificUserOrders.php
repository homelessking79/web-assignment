<?php 

require_once '../background/_DbOperations.php';
require_once '../background/_Response.php';
require_once '../background/_validator.php';

	$responseObj = null;
		
	if($_SERVER['REQUEST_METHOD']=='POST'){	
	  if(isset($_POST['email'])){
			$dbOperationsObject = new DbOperations(); 
			$responseObj = $dbOperationsObject->getUserOrders($_POST['email']);
			echo $responseObj->getResponse();
			exit();
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