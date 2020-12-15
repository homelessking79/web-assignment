<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if($_SERVER['REQUEST_METHOD']=='POST'){	
		if(isset($_POST['ID'])){
			 if(isset($_SESSION['cartItemsData'])){
					$prevItems = $_SESSION['cartItemsData']; 
					$newItems = array();
					
				for($i=0;$i<count($prevItems);$i++){
						
					if ( $prevItems[$i]['product_id'] == $_POST['ID'] ){
						continue;
					}
					array_push($newItems , $prevItems[$i]);
						
				}
			$_SESSION['cartItemsData'] = $newItems;
		}
	  }
	}
?>