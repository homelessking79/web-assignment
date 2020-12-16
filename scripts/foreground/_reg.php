<?php 

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	
	require_once '../background/_DbOperations.php';
	require_once '../background/_Response.php';
	require_once '../background/_validator.php';

	$responseObj = null;

	if($_SERVER['REQUEST_METHOD']=='POST'){	

		if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['re-pass']) && isset($_POST['password']) && isset($_POST['address'] ) && isset($_POST['phone']) ){
			
			$name = trim($_POST['name']);
			$email = trim($_POST['email']);
			$re_pass = trim($_POST['re-pass']);
			$address = trim($_POST['address']);
			$role = 'C';
			$password = trim($_POST['password']);
			$phone = trim($_POST['phone']);
			if(empty($name) || empty($email) || empty($re_pass) || empty($address) || empty($role) || empty($password) || empty($phone) ) {
				if($responseObj == null){
					$responseObj = new Response();
				}
				if(!$responseObj->getError()){
					$responseObj->setError(true);
				}
				$responseObj->setMessage('Please fill in all the fields');
				echo $responseObj->getResponse();
				exit();
			}else{
				if($re_pass != $password){
					if($responseObj == null){
					$responseObj = new Response();
					}
					if(!$responseObj->getError()){
						$responseObj->setError(true);
					}
					$responseObj->setMessage('Passwords do not match');
					$responseObj->setError(true);	
				}
				if (!validator::isValidName($name)){
					if($responseObj == null){
						$responseObj = new Response();
					}
					$responseObj->setError(true);	
					$responseObj->setMessage('Please provide a valid user name');
					$responseObj->setMessage('Only letters and white spaces are allowed');	
				}
				if (!validator::isValidPhone($phone)){
					if($responseObj == null){
						$responseObj = new Response();
					}
					$responseObj->setError(true);	
					$responseObj->setMessage('Please provide a valid Phone number');
					$responseObj->setMessage('Only 10 numbers are allowed');	
				}
				if (!validator::isValidEmail($email)){
					if($responseObj == null){
						$responseObj = new Response();
					}
					if(!$responseObj->getError()){
						$responseObj->setError(true);
					}
					$responseObj->setMessage('Please provide the valid email address');					
				}
				if($responseObj != null){
					if($responseObj->getError()){
						echo $responseObj->getResponse();
						exit();
					}
				}
			}

			$dbOperationsObject = new DbOperations(); 
			$responseObj = $dbOperationsObject->createUser($name , trim($_POST['password'])  ,$email , trim($_POST['address']) ,$role, $phone);
			$data = $responseObj->getContent();
			
			if(!$responseObj->getError()){
				$_SESSION['isLogin'] = true;
				$_SESSION['email'] = $_POST['email'];
				$_SESSION['name'] = $data['user_fname'];
				$_SESSION['role'] = $data['user_role'];
				$_SESSION['phone'] = $data['user_contact'];
				$_SESSION['ID'] = $data['user_id'];
				$_SESSION['address'] = $data['user_address'];
				$_SESSION['pass'] = $_POST['password'];
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
