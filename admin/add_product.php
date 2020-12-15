<?php
include_once 'header.php';
?>

<div class="row">
	<div class="col-lg-12 col-sm-12 col-md-12">
		<h3 class="page-header">Manage Products</h3>
	</div>
</div> <!-- end of first row -->
<div class="row">
	<div class="col-lg-12 col-sm-12 col-md-12">
		<h4 id="error_shower"></h4>
	</div>
</div> <!-- end of first row -->

<div class="row">
	<div class="col-lg-5 col-md-5 col-sm-5">
		<form id='uploadProduct' name="former" enctype="multipart/form-data">
			<h4>Add new Product</h4>
			<div class="form-group">
				<input type="text" class="form-control" name="name" placeholder="Product Name" required="required">
			</div>
			<div class="form-group">
				<input type="number" class="form-control" name="price" placeholder="Price" required>
			</div>
			<div class="form-group">
				<input type="number" class="form-control" name="quantity" placeholder="Quantity" required="required">
			</div>
			<div class="form-group">
				<select name="cat" class="form-control" id="catID">

				</select>
			</div>
			<div class="form-group">
				<select name="brand" id="brandID" class="form-control">
					<script>
						$.ajax({
							type: 'POST',
							url: '../scripts/foreground/getAllCategories.php',
							dataType: "json",
							data: {},
							success: function(data) {
								len = data['data'].length;
								for (i = 0; i < len; i++) {
									$("#catID").append('<option value=' + data['data'][i]['ID'] + '>' + data['data'][i]['Category'] + '</option>');
								}
							},
						});
						$.ajax({
							type: 'POST',
							url: '../scripts/foreground/getAllBrands.php',
							dataType: "json",
							data: {},
							success: function(data) {
								len = data['data'].length;
								for (i = 0; i < len; i++) {
									$("#brandID").append('<option value=' + data['data'][i]['ID'] + '>' + data['data'][i]['Brand'] + '</option>');
								}
							},
						});

						$(document).ready(function() {


							$("#uploadProduct").on('submit', (function(e) {
								e.preventDefault();
								$.ajax({
									url: "../scripts/foreground/addProduct.php",
									type: "POST",
									data: new FormData(this),
									contentType: false,
									dataType: "json",
									cache: false,
									processData: false,
									success: function(data) {

										len = data['message'].length;
										suspect = '';
										for (i = 0; i < len; i++) {
											suspect += data['message'][i] + '\n';
										}

										if (data.error) {
											//document.getElementById("error_shower").innerHTML = suspect;
											swal("Ooopps", suspect, "error");
										} else {
											document.former.reset();
											//document.getElementById("error_shower").innerHTML = suspect;
											swal({
												title: "Success",
												text: suspect,
												icon: "success"
											}).then(function() {
												$('#uploadProduct').trigger("reset");
												window.open('products.php', '_self');
												return;
											});
										}



									},
									error: function(ts) {
										console.log(ts.responseText);
									}
								});
							}));

							$('#add_cat').on('click', function() {
								cat_name = document.cform.cname.value.trim();
								console.log(cat_name);
								$.ajax({
									type: 'POST',
									url: '../scripts/foreground/add_category.php',
									dataType: "json",
									data: {
										'cat': cat_name
									},
									success: function(data) {

										len = data['message'].length;
										suspect = '';
										for (i = 0; i < len; i++) {
											suspect += data['message'][i] + '\n';
										}

										console.log(data);

										if (data.error) {
											swal("Ooopps", suspect, "error");
											return;
										} else {
											swal({
												title: "Success",
												text: suspect,
												icon: "success"
											}).then(function() {
												window.location.reload();
											});
										}
									},
									error: function(ts) {
										console.log(ts.responseText);
									}
								}); // ajax calls ends here	

							}); // button onclick ends here 

							function readURL(input) {
								if (input.files && input.files[0]) {

									imagefile = input.files[0].type;
									match = ["image/jpeg", "image/png", "image/jpg", "image/jfif"];
									if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
										swal("Ooopps", 'Please only choose the image file', "error");
										$('#profile-img').val('');
										return;
									}

									var reader = new FileReader();

									reader.onload = function(e) {
										$('#profile-img-tag').attr('src', e.target.result);
										$('#profile-img-tag').attr('style', 'width:250px;height:250px');
									}
									reader.readAsDataURL(input.files[0]);
								}
							}
							$("#profile-img").change(function() {
								readURL(this);

							});
						}); // jquery parent ends here
					</script>
				</select>
			</div>
			<div class="form-group">
				<input required style="margin-top:20px;" id='profile-img' type="file" name="image" accept="image/*" />
			</div>
			<div class="form-group">
				<button type="submit" id="registerAccount" class="btn btn-primary pull-right">Add Product</button>
			</div>
		</form>
	</div> <!-- tab 1 -->
	<div class="col-lg-3 col-md-3 col-sm-3">
		<img id="profile-img-tag" src="" />
	</div> <!-- end of tab 2 -->
</div> <!-- end of second row -->
<div class="row">

	<div class="col-lg-5 col-md-5 col-sm-5">
		<form name='cform'>
			<h4>Add new Category</h4>
			<div class="form-group">
				<input type="text" class="form-control" name="cname" placeholder="Category Name">
			</div>
			<div class="form-group">
				<button id="add_cat" type='button' class="btn btn-primary pull-right">Add Category</button>
			</div>
		</form>
	</div> <!-- end of tab 2 -->

</div> <!-- end of third row -->


<?php
include_once 'footer.php';
?>