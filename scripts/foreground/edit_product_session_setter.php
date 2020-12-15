<?php
	$suspect = array();
	if($_SERVER['REQUEST_METHOD']=='POST'){	
		$suspect['method_1'] = 'method ' . $_SERVER['REQUEST_METHOD'];
		$suspect['data'] = $_POST['email'] . $_POST['username'] . $_POST['role'];
		if(isset($_POST['email']) && isset($_POST['username']) && isset($_POST['role']) ){
			if ((function_exists('session_status') && session_status() !== PHP_SESSION_ACTIVE) || !session_id()) {
					session_start();
			}
			$_SESSION['isLogin'] = true;
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['role'] = $_POST['role'];
			$suspect['done'] = 'received and set 1111111';
		}else{
			$suspect['method_2'] =  "parameter missing 1111111111111";
		}
	}else{
		$suspect['status'] =  'wrong method';
	}
?>