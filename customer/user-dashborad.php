<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
include_once 'user-header.php';

	if(isset($_SESSION['isLogin'])){
		if($_SESSION['isLogin']){
			if($_SESSION['role'] == 'admin'){
				header('location: http://localhost/xampp/broastnburger/admin/dashboard.php');
				exit();
			}
		}
	}else{
		header('location: http://localhost/xampp/broastnburger/index.php');
		exit();
	}		
	

?>

<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">Dashboard</h3>
	</div> 
</div> <!-- end of first row -->   


<?php
	include_once 'user-footer.php';
?>