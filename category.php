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

	if($_SERVER['REQUEST_METHOD']=='GET'){	
		
		if(isset($_GET['product'])){
			
			$_SESSION['suspectID'] = $_GET['product'];
			$_SESSION['suspectName'] = $_GET['name'];
		}
	}else{
			//echo '<script>alert("wrong method");</script>';	
	}
	
	require_once 'scripts/background/_DBConnect.php';
	$db = new DbConnect();
	$con = $db->connect();
?>

   <!-- Page Content -->
<div class="container" style="margin-top:100px;">
    <div class="row">
		 <!-- Post Content Column -->
      

		<div class="col-lg-3">
				<div class="sidebarblock">
					<h3>Categories</h3>
					<div class="divline"></div>
					<div class="blocktxt">
						<ul class="cats">
							<?php
								$result = $con->query("SELECT * FROM `category`");
									 while($row = $result->fetch_assoc()){
										 
										$stmt = $con->prepare("SELECT count(ID) from products where Category = ?");
										$stmt->bind_param("i", $row['ID']);
										$stmt->execute();
										$counter = $stmt->get_result();
										$counter = $counter->fetch_array(MYSQLI_NUM);
																	 
							?>
											<li><a href="category.php?product=<?php echo $row['ID'] ?>&name=<?php echo $row['Category'] ?>" style="color:grey"><?php echo $row['Category'] ?> </a><span class="badge pull-right"><?php echo $counter[0]; ?></span></li>			 
							<?php
								}
							?>
						</ul>
					</div>
				</div>
				
			<div class="sidebarblock">
				<h3>Featured Products</h3>
				<div class="divline"></div>
				<?php
					$result = $con->query("SELECT p.ID , p.name , p.price , p.picture from products p join category cat on p.Category = cat.ID where p.visible = 'true' and p.featured='true' LIMIT 8");
						 while($row = $result->fetch_assoc()){
				?>
						<div class="blocktxt">
							<a href="#" style="color:grey"><?php echo $row['name']?></a>
						</div>
						<div class="divline"></div>
				<?php
					}
				?>
			</div>

				
			</div>
			
			  <div class="col-9">
		   <div class="container">
			  <h5 class=""><?php echo $_SESSION['suspectName']?></h5>
			  <div class="row">
				
			  
				<?php
					
					$stmt = $con->prepare("SELECT p.ID , p.name , p.price , p.picture from products p join category cat on p.Category = cat.ID where p.visible = 'true' and p.Category = ?");
					$stmt->bind_param("i", $_SESSION['suspectID']);
					$stmt->execute();
					$result = $stmt->get_result();
					while ($row = $result->fetch_array(MYSQLI_NUM)) {
						
				?>
					<div class="col-sm-6 col-md-6 col-lg-4 mb-4 gallery_item"> 
							<div class="card mx-auto text-center image">  
								<img class="card-img-top" src="<?php echo "uploadedImages/".$row[3]?>" alt="Sample Title"> 
								<div class="card-body"> 
									<h5 class="card-title"><?php echo $row[1]?></h5> 
									<h5 style="color:red">Rs . <?php echo $row[2]?></h5> 
								</div> 
							</div> 
							<div class="middle"> 
								<button type="submit" class="btn btn-block btn-danger proChecker"  name='<?php echo $row[1]?>' id='<?php echo $row[0]?>'>
									<span style="font-size:11px">ADD TO CART</span> &nbsp; &nbsp;<i class="fa fa-shopping-cart"></i> 
								</button>
							</div> 
					</div> 		
				<?php
					}
				?>
			  
			  
			  </div>
		   </div>
        </div>

    </div><!-- /.row -->
</div><!-- /.container -->
	
	
 
<script>
	$(document).on('click', '.proChecker', function() {
		id =  $(this).attr('id');
		name =  $(this).attr('name');
		toast = new iqwerty.toast.Toast();
		toast.setText(name + ' added to cart');
		toast.show();
		
		$.ajax({
			  type:'POST',
			  url: "scripts/foreground/addItemToCart_session.php",
			  dataType: "json",
			  data: { 'ID': id}
		});
		
	});
</script>
  
	
	
	
<?php 

 include_once 'customer/footer.php';

?>	
