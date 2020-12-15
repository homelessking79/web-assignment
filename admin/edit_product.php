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
<h4 id="suspecter"></h4>
<div class="row">
	<div class="col-lg-5 col-md-5 col-sm-5">
		<form id='uploadProduct' name="former" enctype="multipart/form-data">

			<div class="form-group">
				<input type="text" class="form-control" name="name" placeholder="Product Name">
			</div>
			<div class="form-group">
				<input type="number" class="form-control" name="price" placeholder="Price">
			</div>
			<div class="form-group">
				<input type="number" class="form-control" name="quantity" placeholder="Quantity">
				<script>
					$(document).ready(function() {

						id = localStorage.getItem('suspectID');



						$.ajax({
							type: 'POST',
							url: '../scripts/foreground/getProductById.php',
							dataType: 'json',
							data: {
								'id': id
							},
							success: function(data) {

								console.log(data);

								document.former.name.value = data['data']['name'];
								document.former.price.value = data['data']['price'];
								document.former.quantity.value = data['data']['quantity'];





								document.getElementById('suspecter').innerHTML = "Edit Product <br><br>[ " + data['data']['name'] + " - " + data['data']['Category'] + " ]<br><br>";

								source = data['data']['picture'];
								pointer = "../uploadedImages/Product/" + source;

								$('#profile-img-tag').attr('src', pointer);
								$('#profile-img-tag').attr('style', 'width:250px;height:250px');


								sus = "<div class='form-group'><input type='number' name='id' value=" + localStorage.getItem('suspectID') + " hidden></div>" +
									"<div class='form-group'><input type='text' name='oldPicAddress' value=" + data['data']['picture'] + " hidden></div>";
								$("#uploadProduct").append(sus);

							},
							error: function(ts) {
								console.log(ts.responseText);
							}
						});


						$("#uploadProduct").on('submit', (function(e) {
							e.preventDefault();
							$.ajax({
								url: "../scripts/foreground/updateProduct.php",
								type: "POST",
								data: new FormData(this),
								contentType: false,
								dataType: "json",
								cache: false,
								processData: false,
								success: function(data) {

									console.log(data);

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
									console.log(ts.responseText + " eror");
								}
							});
						}));


						function readURL(input) {
							if (input.files && input.files[0]) {

								imagefile = input.files[0].type;
								match = ["image/jpeg", "image/png", "image/jpg"];
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
			</div>

			<div class="form-group">
				<input style="margin-top:20px;" id='profile-img' type="file" name="image" accept="image/*" />
			</div>
			<div class="form-group">
				<button type="submit" id="updateProduct" class="btn btn-primary pull-right">Update Product</button>
			</div>
		</form>
	</div> <!-- tab 1 -->
	<div class="col-lg-3 col-md-3 col-sm-3">
		<img id="profile-img-tag" src="" />
	</div> <!-- end of tab 2 -->
</div> <!-- end of second row -->



<?php
include_once 'footer.php';
?>