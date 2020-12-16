<?php 

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	
	require_once '../background/_DbOperations.php';
	require_once '../background/_Response.php';
	require_once '../background/_validator.php';

	$responseObj = null;

	if($_SERVER['REQUEST_METHOD']=='POST'){	

		if(isset($_POST['email']) && isset($_POST['password']) ){
			
			
			if(empty(trim($_POST['password'])) || empty(trim($_POST['email']))){
				if($responseObj == null){
					$responseObj = new Response();
				}
				if(!$responseObj->getError()){
					$responseObj->setError(true);
				}
				$responseObj->setMessage('Please fill in all the fields');
				echo $responseObj->getResponse();
				exit();
			}

			if (!validator::isValidEmail(trim($_POST['email']))){
				if($responseObj == null){
					$responseObj = new Response();
				}
				if(!$responseObj->getError()){
					$responseObj->setError(true);
				}
				$responseObj->setMessage('Please provide the valid email address');	
				echo $responseObj->getResponse();
				exit();				
			}
			
			
			$dbOperationsObject = new DbOperations(); 
			$responseObj = $dbOperationsObject->userLogin(trim($_POST['email']), trim($_POST['password']));
			$data = $responseObj->getContent();
			
			if(!$responseObj->getError()){
				$_SESSION['isLogin'] = true;
				$_SESSION['email'] = $_POST['email'];
				$_SESSION['name'] = $data['user_fname'];
				$_SESSION['role'] = $data['user_role'];
				$_SESSION['ID'] = $data['user_id'];
				$_SESSION['address'] = $data['user_address'];
				$_SESSION['pass'] = $_POST['password'];
				$_SESSION['phone'] = $data['user_contact'];
			}
			
			
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