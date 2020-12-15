<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if (isset($_SESSION['isLogin'])) {
	if ($_SESSION['isLogin']) {
		if ($_SESSION['role'] != 'A') {
			header('location: ../index.php');
			exit();
		}
	}
} else {
	header('location: ../index.php');
	exit();
}


include_once 'header.php';
?>

<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">Manage Products</h3>
		<div style="margin-bottom:20px" class="pull-right gallery_item ">
			<button class="btn btn-block btn-success" type='button' id='addProduct'><span style="font-size:11px">ADD NEW PRODUCT</span> &nbsp; &nbsp;<i class="fa fa-plus"></i></button>
		</div>
	</div>
</div> <!-- end of first row -->

<div class="row">
	<div class="col-lg-12">
		<div class="table-responsive">
			<table class="table table-bordered" style="margin-top:30px;" id="table-cart">
				<tr>
					<td class='table-rows-formatter'> </td>
					<th class='table-primary text-center'> Picture</th>
					<th class='table-primary text-center'> Category</th>
					<th class='table-primary text-center'> Brand</th>
					<th class='table-primary text-center'> Name </th>
					<th class='table-primary text-center'> Price </th>
					<th class='table-primary text-center'> Quantity </th>
					<td class='table-rows-formatter'> </td>
				</tr>

				<script>
					$(document).ready(function() {
						$('#addProduct').on('click', function() {
							window.location.assign("add_product.php");
						});

						email = "<?php

									if (isset($_SESSION['email'])) {
										echo $_SESSION['email'];
									} else {
										echo 'nothing';
									}
									?>";

						$.ajax({
							type: 'POST',
							url: '../scripts/foreground/getAllProducts.php',
							dataType: "json",
							data: {},
							success: function(data) {
								console.log(data);
								len = data['data'].length;
								counter = 0;
								for (i = 0; i < len; i++) {
									source = data['data'][i]['picture'];
									pointer = "../uploadedImages/Product/" + source;

							
									


									suspect = "<tr class='table-primary text-center'>" +
										"<td> <span class='proChecker' style='cursor:pointer' id=" + data['data'][i]['ID'] + "><i class='fa fa-times-circle' style='color:black;font-size:20px;font-weight:bolder'></i></span></td>" +
										'<td> <img src=" ' + pointer + ' " class="img-fluid rounded-circle mb-3" style="width:40px;height:40px" alt="IMG"> </td>' +
										"<td>" + data['data'][i]['Category'] + "</td>" +
										"<td>" + data['data'][i]['brand'] + "</td>" +
										"<td>  " + data['data'][i]['name'] + "</td>" +
										"<td> $" + data['data'][i]['price'] + " </td>" +
										"<td> " + data['data'][i]['quantity'] + " </td>" +
										"<td>  <span class='proCheckerEdit' style='cursor:pointer' id=" + data['data'][i]['ID'] + "><i class='fa fa-edit' style='color:black;font-size:20px;font-weight:bolder'></i></span></td>" +
										"</tr>"

									$("#table-cart").append(suspect);
								}



							},
							error: function(xhr, status, error) {
								var err = eval("(" + xhr.responseText + ")");
								alert(err.Message);
							}
						});


						$.ajax({
							type: 'POST',
							url: '../scripts/foreground/getAllCategories.php',
							dataType: "json",
							data: {},
							success: function(data) {
								console.log(data);
								len = data['data'].length;
								counter = 0;
								for (i = 0; i < len; i++) {


									suspect = "<tr class='table-primary text-center'>" +
										"<td> <span class='checker' style='cursor:pointer' id=" + data['data'][i]['ID'] + "><i class='fa fa-times-circle' style='color:black;font-size:20px;font-weight:bolder'></i></span></td>" +
										"<td>" + data['data'][i]['ID'] + "</td>" +
										"<td>" + data['data'][i]['Category'] + "</td>" +
										"<td> <span class='catCheckerEdit' style='cursor:pointer' name=" + data['data'][i]['Category'] + " id=" + data['data'][i]['ID'] + "><i type='submit' class='fa fa-edit' style='color:black;font-size:20px;font-weight:bolder'></i></span></td>" +
										"</tr>"

									$("#table-cat").append(suspect);
								}

								//products.php?delete="+data['data'][i]['ID']+"&&suspect=category'

							},
							error: function(ts) {
								console.log(ts.responseText);
							}
						});
						$.ajax({
							type: 'POST',
							url: '../scripts/foreground/getAllBrands.php',
							dataType: "json",
							data: {},
							success: function(data) {
								console.log(data);
								len = data['data'].length;
								counter = 0;
								for (i = 0; i < len; i++) {


									suspect = "<tr class='table-primary text-center'>" +
										"<td> <span class='brandchecker' style='cursor:pointer' id=" + data['data'][i]['ID'] + "><i class='fa fa-times-circle' style='color:black;font-size:20px;font-weight:bolder'></i></span></td>" +
										"<td>" + data['data'][i]['ID'] + "</td>" +
										"<td>" + data['data'][i]['Brand'] + "</td>" +
										"<td> <span class='brandCheckerEdit' style='cursor:pointer' name=" + data['data'][i]['Brand'] + " id=" + data['data'][i]['ID'] + "><i type='submit' class='fa fa-edit' style='color:black;font-size:20px;font-weight:bolder'></i></span></td>" +
										"</tr>"

									$("#table-brand").append(suspect);
								}

								//products.php?delete="+data['data'][i]['ID']+"&&suspect=category'

							},
							error: function(ts) {
								console.log(ts.responseText);
							}
						});
						$(document).on('click', '.checker', function() {
							id = $(this).attr('id');

							flager = $(this).parent().parent()

							swal({
								title: "Delete Category !",
								buttons: ["Cancel", "Delete"],
							}).then(function(value) {
								console.log(value);
								if (value != null) {
									$.ajax({
										type: "POST",
										url: "../scripts/foreground/deleteCategory.php",
										dataType: "json",
										data: {
											"id": id
										},
										success: function(data) {
											console.log(data);
											if (data.error) {
												swal("Ooopps", data.message + "", "error");
											} else {
												swal({
													title: "success",
													text: data.message + "",
													icon: "success"
												}).then(function() {

													flager.remove();

													//window.open("products.php", "_self");	
													return;
												});

											}


										},
										error: function(ts) {
											console.log(ts.responseText);
										}
									});
								} else {
									// window.open("products.php", "_self");	
								}
							});
						});


						$(document).on('click', '.proChecker', function() {
							id = $(this).attr('id');

							flager = $(this).parent().parent()

							swal({
								title: "Delete Product !",
								buttons: ["Cancel", "Delete"],
							}).then(function(value) {
								console.log(value);
								if (value != null) {
									$.ajax({
										type: "POST",
										url: "../scripts/foreground/deleteProduct.php",
										dataType: "json",
										data: {
											"id": id
										},
										success: function(data) {
											console.log(data);
											if (data.error) {
												swal("Ooopps", data.message + "", "error");
											} else {
												swal({
													title: "success",
													text: data.message + "",
													icon: "success"
												}).then(function() {

													flager.remove();

													//window.open("products.php", "_self");	
													return;
												});

											}


										},
										error: function(ts) {
											console.log(ts.responseText);
										}
									});
								} else {
									// window.open("products.php", "_self");	
								}
							});
						});

						$(document).on('click', '.proCheckerEdit', function() {
							id = $(this).attr('id');
							localStorage.setItem("suspectID", id);
							window.open('edit_product.php', '_self');
						});

						$(document).on('click', '.catCheckerEdit', function() {
							id = $(this).attr('id');
							name = $(this).attr('name');
							localStorage.setItem("suspectID", id);
							localStorage.setItem("suspectName", name);
							window.open('edit_category.php', '_self');
						});


					});
				</script>
			</table>
		</div>
	</div> <!-- whole tab-->

</div> <!-- end of second row -->


<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">Categories</h3>
		<div class="table-responsive">
			<table class="table table-bordered" style="margin-top:30px;" id="table-cat">
				<tr>
					<td class='table-rows-formatter'> </td>
					<th class='table-primary text-center'> ID </th>
					<th class='table-primary text-center'> Category </th>
					<td class='table-rows-formatter'> </td>
				</tr>
			</table>
		</div>
	</div> <!-- whole tab-->

</div>
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">Brands</h3>
		<div class="table-responsive">
			<table class="table table-bordered" style="margin-top:30px;" id="table-brand">
				<tr>
					<td class='table-rows-formatter'> </td>
					<th class='table-primary text-center'> ID </th>
					<th class='table-primary text-center'> Brand </th>
					<td class='table-rows-formatter'> </td>
				</tr>
			</table>
		</div>
	</div> <!-- whole tab-->

</div> <!-- end of second row -->




<?php
include_once 'footer.php';
?>