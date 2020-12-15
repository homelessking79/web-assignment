<?php 

require_once '../background/_DbOperations.php';

	$response = array();

	if($_SERVER['REQUEST_METHOD']=='POST'){	

		if(isset($_POST['email']) && isset($_POST['ids']) && isset($_POST['price']) ){
			$dbOperationsObject = new DbOperations(); 
			$response = $dbOperationsObject->orderLaptop(trim($_POST['email']), trim($_POST['ids']), trim($_POST['price']));
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