<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

require_once '../background/_DbOperations.php';
require_once '../background/_Response.php';
require_once '../background/_validator.php';

$responseObj = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['address']) && isset($_POST['name'])) {
		$id = $_SESSION['ID'];
		$phone = trim($_POST['phone']);
		$email = trim($_POST['email']);
		$address = trim($_POST['address']);
		$name = trim($_POST['name']);
		if (empty($phone) || empty($email) || empty($address) || empty($name)) {
			if ($responseObj == null) {
				$responseObj = new Response();
			}
			if (!$responseObj->getError()) {
				$responseObj->setError(true);
			}
			$responseObj->setMessage('Please fill in all the fields');
			echo $responseObj->getResponse();
			exit();
		} else {
			
			if (!validator::isValidName($name)){
				if($responseObj == null){
					$responseObj = new Response();
				}
				$responseObj->setError(true);	
				$responseObj->setMessage('Please provide a valid user name');
				$responseObj->setMessage('Only letters and white spaces are allowed');	
			}
			if (!validator::isValidPhone($phone)) {
				if ($responseObj == null) {
					$responseObj = new Response();
				}
				$responseObj->setError(true);
				$responseObj->setMessage('Please provide a valid Phone number'.$phone );
				$responseObj->setMessage('Only 10 numbers are allowed');
			}
			if (!validator::isValidEmail($email)) {
				if ($responseObj == null) {
					$responseObj = new Response();
				}
				if (!$responseObj->getError()) {
					$responseObj->setError(true);
				}
				$responseObj->setMessage('Please provide the valid email address');
			}
			if ($responseObj != null) {
				if ($responseObj->getError()) {
					echo $responseObj->getResponse();
					exit();
				}
			}
		}

		$dbOperationsObject = new DbOperations();
		$responseObj = $dbOperationsObject->updateUser($id,$phone, $email, $address, $name);
		//$data = $responseObj->getContent();

		if (!$responseObj->getError()) {
			$_SESSION['isLogin'] = true;
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['phone'] = $_POST['phone'];
			$_SESSION['address'] = $_POST['address'];
			$_SESSION['name'] =  $_POST['name'];
		}

		echo $responseObj->getResponse();
		exit();
	} else {
		if ($responseObj == null) {
			$responseObj = new Response();
		}

		$responseObj->setError(true);
		$responseObj->setMessage('Required parameters are missing');
		echo $responseObj->getResponse();
		exit();
	}
} else {
	if ($responseObj == null) {
		$responseObj = new Response();
	}
	$responseObj->setError(true);
	$responseObj->setMessage('Invalid Request');
	echo $responseObj->getResponse();
	exit();
}
