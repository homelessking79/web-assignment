<?php 

require_once '../background/_DbOperations.php';
require_once '../background/_Response.php';

	$responseObj = null;

	if($_SERVER['REQUEST_METHOD']=='POST'){	
		$dbOperationsObject = new DbOperations(); 
		$responseObj = $dbOperationsObject->getAllOrders();
		echo $responseObj->getResponse();
		exit();
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