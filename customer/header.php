<?
	
	

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>E-laptop</title>

	<!-- Bootstrap -->
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- fonts -->
	<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
	<link href="vendor/fonts.css" rel="stylesheet" type="text/css">

	<!-- icons -->
	<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<!-- stylesheet -->
	<link href="css/landing-page.css" rel="stylesheet">
	<!--link href="css/navigation.css" rel="stylesheet"-->
	<link href="css/form.css" rel="stylesheet">
	<link href="css/gallery_hover.css" rel="stylesheet">

	<script src="vendor/sweet_alert.min.js"></script>
	<script src="css/toaster.js"></script>

</head>

<body>

	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg  navbar-dark bg-dark sticky-top">
		<div class="container">
			<a class="navbar-brand" href="./index.php">
				E-Laptop
			</a>
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>


			<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link js-scroll-trigger" href="./index.php">Home </a>
					</li>
					<li class="nav-item">
						<a class="nav-link js-scroll-trigger" href="./products.php">Products </a>
					</li>
					<li class="nav-item">
						<a class="nav-link js-scroll-trigger" href="./contact.php">Contact us </a>
					</li>

					<li class="nav-item">
						<a class="nav-link js-scroll-trigger" href="./login.php">Log in </a>
					</li>
					<li class="nav-item">
						<i class="nav-link js-scroll-trigger fa fa-shopping-cart fa-fw" id="cartButton" data-toggle="modal" data-target="#myModal" style="color:white;font-size:22px;"></i>
					</li>

				</ul>
			</div>
		</div>

	</nav>

	<!--  end navbar -->



	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Cart</h4>
				</div>
				<div class="modal-body">
					<div class="container">

						<ul class="list-group" id="cartContainer">

							<script>
								$(document).ready(function() {

									$('#proceedToCheck').on('click', function() {
										window.open('./cart.php', '_self');
									});


									$('#cartButton').on('click', function() {
										$('#cartContainer').empty();
										$.ajax({
											type: 'POST',
											url: './scripts/foreground/getCartItems_session.php',
											dataType: "json",
											data: {},
											success: function(data) {


												if (data['error']) {

													formatter = '  <li class="list-group-item"> <div class="row"> ' +
														'	<strong style="margin-left:20px;"> Cart is empty</strong>' +
														' </div>   </li> ';
													$("#cartContainer").append(formatter);
												} else {

													dataLength = data['data'].length;
													for (i = 0; i < dataLength; i++) {

														//console.log(data[i]);

														source = data['data'][i]['product_img1'];
														pointer = " ./uploadedImages/Product/" + source;

														sus = data['data'][i]['product_title'] + '<br>$ ' + data['data'][i]['price'];

														console.log(pointer);
														formatter = '  <li class="list-group-item"> <div class="row"> '

															+
															'	<img src=" ' + pointer + ' " class="img-fluid col-sm-2 rounded-circle " style="width:40px;height:40px" alt="IMG"> '


															+
															'	<strong  class="col-sm-10"> ' + sus + '</strong>' 
															+
															' </div>   </li> ';

														$("#cartContainer").append(formatter);

													}
												}


											},
											error: function(ts) {
												console.log(ts.responseText);
											}
										});

									}); // button onclick ends here 
								}); // jquery parent ends here 
							</script>



						</ul>
					</div>
					<!--container -->
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-outline-primary pull-right" value="Proceed to checkout" id="proceedToCheck">
				</div>
			</div>
		</div>
	</div>
