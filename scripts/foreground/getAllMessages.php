<?php 

require_once '../background/_DbOperations.php';

	$response = array();

	if($_SERVER['REQUEST_METHOD']=='POST'){	
		$dbOperationsObject = new DbOperations(); 
		$response = $dbOperationsObject->getAllMessages();
	}else{
		$response['error'] = true;
		$response['message'] = 'invalid request';
	}
	
	echo json_encode($response);

?>