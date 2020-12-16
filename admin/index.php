<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if (isset($_SESSION['isLogin'])) {
	if ($_SESSION['isLogin']) {
		if ($_SESSION['role'] == 'A') {
			header('location: ./products.php');
			exit();
		} else if($_SESSION['role'] == 'C'){
            header('location: ../index.php');
			exit();
        }
	}
} else {
	header('location: ../login.php');
	exit();
}
