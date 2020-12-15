<?php
require_once '../background/_DbOperations.php';
require_once '../background/_Response.php';
require_once '../background/_validator.php';

	$responseObj = null;

  	if($_SERVER['REQUEST_METHOD']=='POST'){	
		
		if(isset($_FILES['image']) && isset($_POST['email'])){
		
			$image = $_FILES['image']['name'];
			$res = round(microtime(true) * 1000);
			$image_server_name = $res."-bnb-".basename($image);
			$target = "../../uploadedImages/".$image_server_name;

			if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
				$dbOperationsObject = new DbOperations(); 
				$responseObj = $dbOperationsObject->updateProfile($image_server_name,$_POST['email']);
				echo $responseObj->getResponse();
				exit();
			}else{
				if($responseObj == null){
					$responseObj = new Response();
				}
					$responseObj->setError(true);	
					$responseObj->setMessage('Failed to upload the image');	
					echo $responseObj->getResponse();
					exit();
			}
		}else{
			if($responseObj == null){
				$responseObj = new Response();
			}
			$responseObj->setError(true);	
			$responseObj->setMessage('Required parameters are missing');	
			//echo $responseObj->getResponse();
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