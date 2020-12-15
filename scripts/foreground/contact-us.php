<?php 

require_once '../background/_DbOperations.php';

	$response = array();

	if($_SERVER['REQUEST_METHOD']=='POST'){	

		if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message']) && isset($_POST['subject'])){
			$dbOperationsObject = new DbOperations(); 
			$response = $dbOperationsObject->sendMessage($_POST['name'] , $_POST['email']  , $_POST['email'], $_POST['message'] , $_POST['subject'] );
		}else{
			$response['error'] = true;
			$response['message'] = 'Required parameters are missing';
		}
	
	}else{
		$response['error'] = true;
		$response['message'] = 'invalid request';
	}
	
	echo json_encode($response);

?>