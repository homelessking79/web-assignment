<?php
	
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	
	$_SESSION['call_to_action_button_email'] = '';
	
		if($_SERVER['REQUEST_METHOD']=='POST'){	
			if(isset($_POST['email']) && isset($_POST['call_to_action_button'])){
				$_SESSION['call_to_action_button_email'] = $_POST['email'];
			}
		}
		
		if(isset($_SESSION['isLogin'])){
			if($_SESSION['isLogin']){
				if($_SESSION['role'] == 'C'){
					header('location: index.php');
					exit();
				}else if($_SESSION['role'] == 'A'){
					header('location: admin/products.php');
					exit();
				}
			}
		}	
include_once 'customer/header.php';
?>

    <!-- FORM -->
    <section class="testimonials text-center bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="signup-form">	
			  <form name="former">
				 <h2>Create Account</h2>
				 <div class="form-group">
					<input type="text" class="form-control" name="username" placeholder="Full Name" required="required">
				 </div>
				  <div class="form-group">
					<input type="email" class="form-control" name="email" value="<?php echo $_SESSION['call_to_action_button_email'] ?>" placeholder="Email Address">
				 </div>
				 <div class="form-group">
					<input type="password" class="form-control" name="password" placeholder="Password" required="required">
				 </div>
				 <div class="form-group">
					<input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required="required">
				 </div>     
				<div class="form-group">
					<textarea style="resize: none;" class="form-control" rows="4" name="address" placeholder="Address" required="required"></textarea>
				 </div>
				 <div class="form-group">
					<input type="text" class="form-control" name="phone" placeholder="Phone number" required="required">
				 </div>    				 
				 <div class="form-group">
					<button type="button" id="registerAccount" class="btn btn-primary btn-block btn-lg">Sign Up</button>
				 </div>
				 <p class="small text-center">By clicking the Sign Up button, you agree to our <br><a href="#">Terms &amp; Conditions</a>, and <a href="#">Privacy Policy</a>.</p>
				</form>
				<div class="text-center">Already have an account ? <a href="login.php">Login here</a></div>
			</div>
			
			
          </div><!-- CONTENT -->
        </div><!-- row -->
      </div><!-- container -->
    </section>

	<script>

		$(document).ready(function(){

			 $('#registerAccount').on('click',function(){
	
				name = document.former.username.value.trim();
				email = document.former.email.value.trim();
				password = document.former.password.value.trim();
				repass = document.former.confirm_password.value.trim();
				address = document.former.address.value.trim();
				phone = document.former.phone.value.trim();
				 $.ajax({
					type:'POST',
					url:'scripts/foreground/_reg.php',
					dataType: "json",
					data:{'name':name, 'email':email , 'password':password , 're-pass':repass ,'address':address, 'phone':phone},
					success:function(data){
						 len = data['message'].length;
						 console.log(data['message']);
						 suspect = '';
						 for (i=0;i<len;i++) {
							 suspect += data['message'][i] + '\n';
						}
						
						if(data.error){
							swal("Ooopps",suspect, "error");
						}else{
						
							 swal({ 
								   title: "Congratulations",
								   text: suspect,
								   icon: "success" 
								   
									}).then(function() {
									    document.former.reset();		
										window.open('index.php', '_self');
										return;
							});
						} 
					},
					error: function(ts) { console.log(ts.responseText);}
				});	
			});
		});	
</script>
    

<?php  include_once 'customer/footer.php'; ?>