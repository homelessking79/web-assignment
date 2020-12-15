	<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	 //echo $_SESSION['cartItems'].'<br>';
	 if(isset($_SESSION['cartItemsData'])){
			$prevItems = $_SESSION['cartItemsData']; 
			$arr = array();
			
			
			if(count($prevItems) == 0){
				$arr['error'] = true;
				$arr['data'] = null;
			}else{
				$arr['error'] = false;
				$arr['data'] = $prevItems;
				$arr['count'] = count($prevItems);
			}
			
			echo json_encode($arr);
	}else{
		$arr['error'] = true;
		$arr['data'] = null;
		echo json_encode($arr);
	}
	/*
	print_r($arr);
			for($i=0;$i<count($arr['data']);$i++){
				
				
				echo $arr['data'][$i].",";
				
			}  */
	?>