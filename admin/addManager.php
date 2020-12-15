<?php
include_once 'header.php';
?>

<div class="row">
	<div class="col-lg-12 col-sm-12 col-md-12">
		<h3 class="page-header">Manage Users</h3>
	</div>
</div> <!-- end of first row -->

<div class="row">
	<div class="col-lg-5 col-md-5 col-sm-5">
		<form name="former">
			<h4>Add new Manager</h4>
			<div class="form-group">
				<input type="text" class="form-control" name="username" placeholder="Full Name" required="required">
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="email" placeholder="Email Address">
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="password" placeholder="Password">
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password">
			</div>
			<div class="form-group">
				<textarea style="resize: none;" class="form-control" rows="4" name="address" placeholder="Address"></textarea>
			</div>
			<div class="form-group">
				<button type="button" id="registerAccount" class="btn btn-primary pull-right">Create Account</button>
			</div>
		</form>
	</div> <!-- tab 1 -->
	<div class="col-lg-3 col-md-3 col-sm-3">
		<img id="profile-img-tag" src="" />
	</div> <!-- end of tab 2 -->
</div> <!-- end of second row -->


<script>
	$(document).ready(function() {

		$('#registerAccount').on('click', function() {

			name = document.former.username.value.trim();
			email = document.former.email.value.trim();
			password = document.former.password.value.trim();
			repass = document.former.confirm_password.value.trim();
			address = document.former.address.value.trim();

			$.ajax({
				type: 'POST',
				url: '../scripts/foreground/_reg.php',
				dataType: "json",
				data: {
					'name': name,
					'email': email,
					'password': password,
					're-pass': repass,
					'role': 'A',
					'address': address
				},
				success: function(data) {
					len = data['message'].length;
					suspect = '';
					for (i = 0; i < len; i++) {
						suspect += data['message'][i] + '\n';
					}

					if (data.error) {
						swal("Ooopps", suspect, "error");
					} else {

						// $.ajax({
						//   url: "registration.php",
						//   method: "POST",
						//   data: { 'username': name , 'email':email , 'role':'customer' }
						// });

						swal({
							title: "Congratulations",
							text: suspect,
							icon: "success"
						}).then(function() {
							document.former.reset();
							window.open('users.php', '_self');
							return;
						});
					}
				},
				error: function(ts) {
					console.log(ts.responseText);
				}
			});
		});
	});
</script>


<?php
include_once 'footer.php';
?>