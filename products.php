<?php

if ((function_exists('session_status') && session_status() !== PHP_SESSION_ACTIVE) || !session_id()) {
	session_start();
}

if (isset($_SESSION['isLogin'])) {
	if ($_SESSION['isLogin']) {
		if ($_SESSION['role'] == 'C') {
			include_once 'customer/header-login.php';
		} else if ($_SESSION['role'] == 'A') {
			header('location: admin/products.php');
			exit();
		}
	}
} else {

	include_once 'customer/header.php';
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
						while ($row = $result->fetch_assoc()) {

							$stmt = $con->prepare("SELECT count(product_id) from products where cat_id = ?");
							$stmt->bind_param("i", $row['cat_id']);
							$stmt->execute();
							$counter = $stmt->get_result();
							$counter = $counter->fetch_array(MYSQLI_NUM);

						?>
							<li><a href="category.php?product=<?php echo $row['cat_id'] ?>&name=<?php echo $row['cat_id'] ?>" style="color:grey"><?php echo $row['cat_title'] ?> </a><span class="badge pull-right"><?php echo $counter[0]; ?></span></li>
						<?php
						}
						?>
					</ul>
				</div>
			</div>

			<div class="sidebarblock">
				<h3 id="ALL" style="cursor: pointer;">Brands</h3>
				<div class="divline"></div>
				<?php
				$result = $con->query("SELECT * from brands");
				while ($row = $result->fetch_assoc()) {
				?>
					<div class="blocktxt">
						<div  style="color:grey; cursor:pointer;" class="filter" id="<?php echo $row['brand_title'] ?>"><?php echo $row['brand_title']  ?> </div>
					</div>
					<div class="divline"></div>
				<?php
				}
				?>
			</div>


		</div>

		<div class="col-9">
			<div class="container">
				<h1 class="my-4 text-center text-lg-center"></h1>
				<div class="row">


					<?php
					$result = $con->query("SELECT p.product_id , p.product_title , p.price , p.product_img1, b.brand_title from products p, brands b where p.brand_id = b.brand_id");
					while ($row = $result->fetch_assoc()) {
					?>

						<div class="col-sm-6 col-md-6 col-lg-4 mb-4 gallery_item filterItem product-<?php echo $row['brand_title'] ?>" id="productID<?php echo $row['product_id'] ?> " >
							<div id="<?php echo $row['product_id'] ?> " class="product_detail  " style="cursor: pointer;">
								<div class="card mx-auto text-center image">
									<img class="card-img-top" src="<?php echo "uploadedImages/Product/" . $row['product_img1'] ?>" alt="Sample Title">
									<div class="card-body">
										<h5 class="card-title"><?php echo $row['product_title'] ?></h5>
										<h5 style="color:red">$<?php echo $row['price'] ?></h5>
									</div>
								</div>
								<div class="middle">
									<button type="submit" class="btn btn-block btn-danger proChecker" name='<?php echo $row['product_title'] ?>' id='<?php echo $row['product_id'] ?>'>
										<span style="font-size:11px">ADD TO CART</span> &nbsp; &nbsp;<i class="fa fa-shopping-cart"></i>
									</button>
								</div>
							</div>
							<script>
								$(document).on('click', '.product_detail', function() {
									id = $(this).attr('id');
									console.log("ok");
									localStorage.setItem('product-id', id);
									window.open("./product_detail.php","_self");
									// $.ajax({
									// 	type: 'POST',
									// 	url: "./product_detail.php",
									// 	dataType: "json",
									// 	data: {
									// 		'id': id
									// 	},
									// 	success: function(data) {
									// 		console.log("ok");
									// 		window.open('product_detail.php', '_self');
									// 		// $.ajax({
									// 		// 	type: 'POST',
									// 		// 	url: "./product_detail.php",
									// 		// 	dataType: "json",
									// 		// 	data: {
									// 		// 		'data': data.data.ID
									// 		// 	},
									// 		// 	success: function(data) {
									// 		// 		window.op
									// 		// 	}
									// 		// });
									// 	}
									// });
								});
							</script>
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
	// $(document).on('click','.filter',function(){
	// 	brand = $(this).attr('id');
	// 	itemBrand =  $('.filterItem');
	// 	for(i=0; i<itemBrand.length;i++){
	// 		if(itemBrand[i].className.indexOf(brand) == -1){
	// 			console.log("ok");
	// 			itemID = '#'+itemBrand[i].id;
	// 			console.log(itemID);
	// 			console.log(document.getElementById('#productID1'));
	// 		}
	// 	}
	// 	console.log(itemBrand);
	// })

	$('#DELL').on('click', function() {
		console.log('alo')
		$('.product-LENOVO').hide();
		$('.product-Apple').hide();
		$('.product-DELL').show();
	})
	$('#LENOVO').on('click', function() {
		console.log('alo')
		$('.product-DELL').hide();
		$('.product-Apple').hide();
		$('.product-LENOVO').show();
	})
	$('#Apple').on('click', function() {
		console.log('alo')
		$('.product-DELL').hide();
		$('.product-LENOVO').hide();
		$('.product-Apple').show();
	})
	$('#ALL').on('click', function() {
		console.log('alo')
		$('.product-DELL').show();
		$('.product-LENOVO').show();
		$('.product-Apple').show();
	})
	$(document).on('click', '.proChecker', function() {
		id = $(this).attr('id');
		name = $(this).attr('name');
		toast = new iqwerty.toast.Toast();
		toast.setText(name + ' added to cart');
		toast.show();

		$.ajax({
			type: 'POST',
			url: "scripts/foreground/addItemToCart_session.php",
			dataType: "json",
			data: {
				'ID': id
			}
		});

	});
</script>




<?php

include_once 'customer/footer.php';

?>