<?php

if ((function_exists('session_status') && session_status() !== PHP_SESSION_ACTIVE) || !session_id()) {
	session_start();
}

if (isset($_SESSION['isLogin'])) {
	if ($_SESSION['isLogin']) {
		if ($_SESSION['role'] == 'C') {
			include_once 'customer/header-login.php';
		} else if ($_SESSION['role'] == 'C') {
			header('location: admin/products.php');
			exit();
		}
	}
} else {
	header('location: index.php');
	exit();
}
?>

<div class="container h-100" style="margin-top :100px;">
	<h1 class="my-4 text-center text-lg-center ">Welcome <?php echo $_SESSION["name"] ?></h1>
	<div class="row h-100 justify-content-center align-items-center">
		<img src="images/user.png" id="profile-img-tag" style="width:280px;height:280px" class="img-fluid rounded-circle mb-3" />
	</div>
	<div class="row h-100 justify-content-center align-items-center">
		<form id='uploadProfile' name="former">

			<div class="form-group pull-right">
				<label for="name" style="display: inline;">Username:</label><input type="text" class="form-control mb-3" value='<?php
																																if (isset($_SESSION["name"])) {
																																	echo $_SESSION["name"];
																																} else {
																																	echo "";
																																}
																																?>' ; name="name">
				<label for="email" style="display: inline;">Email:</label><input type="text" class="form-control mb-3" value='<?php
																																if (isset($_SESSION["email"])) {
																																	echo $_SESSION["email"];
																																} else {
																																	echo "";
																																}
																																?>' ; name="email">
				<label for="address" style="display: inline;">Address:</label><input type="text" class="form-control mb-3" value='<?php
																																	if (isset($_SESSION["address"])) {
																																		echo $_SESSION["address"];
																																	} else {
																																		echo "";
																																	}
																																	?>' ; name="address">
				<label for="phone" style="display: inline;">Phone Number:</label><input type="text" class="form-control mb-3" value='<?php
																																		if (isset($_SESSION["phone"])) {
																																			echo $_SESSION["phone"];
																																		} else {
																																			echo "";
																																		}
																																		?>' ; name="phone">

				<button id="add_cat" type='submit' class="btn btn-primary" style="padding-left: 150px; padding-right: 150px;">Update Profile</button>
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function() {


		email = document.former.email.value.trim();
		phone = document.former.phone.value.trim();
		address = document.former.address.value.trim();

		$("#uploadProfile").on('submit', (function(e) {
			console.log("alo" + address);
			e.preventDefault();
			$.ajax({
				url: "./scripts/foreground/update_user_profile.php",
				type: "POST",
				data: new FormData(this),
				contentType: false,
				dataType: "json",
				cache: false,
				processData: false,
				success: function(data) {
					console.log(data['message']);
					len = data['message'].length;
					suspect = '';
					for (i = 0; i < len; i++) {
						suspect += data['message'][i] + '\n';
					}

					if (data.error) {

						swal("Ooopps", suspect, "error");
					} else {
						//document.former.reset();

						swal({
							title: "Success",
							text: suspect,
							icon: "success"
						}).then(function() {
							$('#uploadProfile').trigger("reset");
							window.open('index.php', '_self');
							return;
						});
					}



				},
				error: function(ts) {
					console.log(ts.responseText);
				}
			});
		}));
	}); // jquery parent ends here
</script>


<?php include_once 'customer/footer.php'; ?>