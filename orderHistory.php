<?php
		
	if ((function_exists('session_status') && session_status() !== PHP_SESSION_ACTIVE) || !session_id()) {
		session_start();
	}
	
	if(isset($_SESSION['isLogin'])){
		if($_SESSION['isLogin']){
			if($_SESSION['role'] == 'customer'){
				include_once 'customer/header-login.php';
			}else if($_SESSION['role'] == 'admin'){
				header('location: admin/products.php');
				exit();
			}
		}
	}else{
	
		include_once 'customer/header.php';
	}
	require_once 'scripts/background/_DBConnect.php';
	$db = new DbConnect();
	$con = $db->connect();
?>

<div class="container" style="margin-top:100px">
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header" id='error_shower'>Orders</h3>
	</div> 
</div> <!-- end of first row -->   
			
<div class="row">
    <div class="col-lg-12">
		<div class="table-responsive"> 	
			<table class="table table-bordered" style="margin-top:30px;" id="table-cart">
					<tr>
						<th class='text-center'> Order ID</th>
						<th class='text-center'> Price </th>
						<th class='text-center'> Date </th>
					</tr>

					<?php
						$stmt = $con->prepare("SELECT * from orders where user_id=?");
						$stmt->bind_param("s",$_SESSION['ID']);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($orderID,$userID,$price,$order_date,$items);

						$arrID = array();
						if($stmt->num_rows >0) {
							while($row = $stmt->fetch()){
								$seconds = $order_date / 1000;
								?>
								<tr class='text-center'>
									<td><?php echo $orderID?></td>
									<td><?php echo $price?></td>
									
									<td><?php echo date("D M , Y  ---  h : i", (int)$seconds);?></td>
						
								</tr>
						<?php
							}
							$error = false;
						}else{
							$error = true;
						}
								
					?>
			</table>
		</div>
    </div>  <!-- whole tab-->
				
</div> <!-- end of second row -->
				
</div> <!-- end of second row -->
		
	
<?php  include_once 'customer/footer.php'; ?>