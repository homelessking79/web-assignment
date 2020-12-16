<?php
require_once '../background/_DbOperations.php';
require_once '../background/_Response.php';
require_once '../background/_validator.php';

	$responseObj = null;

  	if($_SERVER['REQUEST_METHOD']=='POST'){	
		
		if( isset($_POST['name']) && isset($_POST['price']) && isset($_POST['quantity']) && isset($_POST['id']) && isset($_POST['trending']) ){
			$dbOperationsObject = new DbOperations(); 
			
			$name = trim($_POST['name']);
			$price = trim($_POST['price']);
			$quantity = trim($_POST['quantity']);
			$trend = (int)$_POST['trending'];
			// $cat = trim($_POST['cat']);
			// $cat = $dbOperationsObject->getCategoryIDByName($cat);
			// $visible = 'false';
			// $featured = 'false';
			
			// if (!validator::isValidName($name)){
			// 	if($responseObj == null){
			// 		$responseObj = new Response();
			// 	}
			// 	if(!$responseObj->getError()){
			// 		$responseObj->setError(true);
			// 	}
			// 	$responseObj->setMessage('Please provide the valid product name');				
			// }
			if($price < 0){
				if($responseObj == null){
					$responseObj = new Response();
				}
				if(!$responseObj->getError()){
					$responseObj->setError(true);
				}
				$responseObj->setMessage('Price can not be negative');	
			}
			if($quantity < 0){
				if($responseObj == null){
					$responseObj = new Response();
				}
				if(!$responseObj->getError()){
					$responseObj->setError(true);
				}
				$responseObj->setMessage('Quantity can not be negative');	
			}
			
			if($responseObj != null){
				if($responseObj->getError()){
					echo $responseObj->getResponse();
					exit();
				}
			}
			
			
			if( empty($_FILES['image']['name']) ){
				$responseObj = $dbOperationsObject->updateProduct($name , $price  , $quantity , $_POST['oldPicAddress'],$_POST['id'],$trend);
				echo $responseObj->getResponse();
				exit();
			}else{
				$image = $_FILES['image']['name'];
				$res = round(microtime(true) * 1000);
				$image_server_name = $res.basename($image);
				$target = "../../uploadedImages/Product/".$image_server_name;

				if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
					$responseObj = $dbOperationsObject->updateProduct($name , $price  , $quantity , $image_server_name,$_POST['id'],$trend);
					echo $responseObj->getResponse();
					exit();
				}else{
					if($responseObj == null){
						$responseObj = new Response();
					}
						$responseObj->setError(true);	
						$responseObj->setMessage('Failed to upload the image = '.print_r($_FILES['image']));	
						echo $responseObj->getResponse();
						exit();
				}
			}
			
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
