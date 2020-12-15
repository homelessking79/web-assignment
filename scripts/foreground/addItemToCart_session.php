<?php
	
	require_once '../background/_DbOperations.php';
	require_once '../background/_Response.php';

		if(isset($_POST['ID'])){
			
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}

			if(isset($_SESSION['cartItemsData'])){
				$prevItems = $_SESSION['cartItemsData']; 
				
				if(searchForId($_POST['ID'] , $prevItems ) == -99){
					$dbOperationsObject = new DbOperations(); 
					$responseObj = $dbOperationsObject->getProductByID($_POST['ID']);
				
					$arr = $_SESSION['cartItemsData']; 
				//	$arr = explode('&', $prevItemsData);
					array_push($arr ,  $responseObj->getResponseData());
	
					$_SESSION['cartItemsData'] = $arr;	
				}else{
					
					echo 'already present';
				}
				
				
				
			}else{
			
				$dbOperationsObject = new DbOperations(); 
				$responseObj = $dbOperationsObject->getProductByID($_POST['ID']);
				
				$arr = array();
				array_push($arr ,  $responseObj->getResponseData());
				$_SESSION['cartItemsData'] = $arr;
				
			}
		}else{
				echo 'para error';
		}
	
	
	function searchForId($id, $array) {
	   foreach ($array as $key => $val) {
		   if ($val['ID'] === $id) {
			   return $key;
		   }
	   }
		return -99;
	}
?>