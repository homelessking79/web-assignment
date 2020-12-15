<?php
	if ((function_exists('session_status') && session_status() !== PHP_SESSION_ACTIVE) || !session_id()) {
		session_start();
	}
   
	if(isset($_SESSION['isLogin'])){
		if($_SESSION['isLogin']){
			if($_SESSION['role'] == 'customer'){
				header('location: customer/user-dashborad.php');
				exit();
			}else if($_SESSION['role'] == 'admin'){
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
			  <form name='former'>
				 <h2>Member Login</h2>
				 <div class="form-group">
					<input type="email" class="form-control" name="email" placeholder="Email Address" required>
				 </div>
				 <div class="form-group">
					<input type="password" class="form-control" name="password" placeholder="Password" required>
				 </div>    
				 <div class="form-group">
					<button type="button" id="accessAccount" class="btn btn-primary btn-block btn-lg">Login</button>
				 </div>
				</form>
				<div class="text-center">Don't have account ? <a href="registration.php">create account here</a></div>
			</div>
			
			
          </div><!-- CONTENT -->
        </div><!-- row -->
      </div><!-- container -->
    </section>
	
	<script>
		$(document).ready(function(){

			 $('#accessAccount').on('click',function(){
				
				email = document.former.email.value.trim();
				password = document.former.password.value.trim();
				

				 $.ajax({
					type:'POST',
					url:'scripts/foreground/_login.php',
					dataType: "json",
					data:{'email':email , 'password':password},
					success:function(data){
						
						 len = data['message'].length;
						 suspect = '';
						 for (i=0;i<len;i++) {
							 suspect += data['message'][i] + '\n';
						}
						
						console.log(data);
						
						if(data.error){
							swal("Ooopps",suspect, "error");
							 return;
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
				}); // ajax calls ends here 	
			}); // button onclick ends here 
		});// jquery parent ends here 
	</script>
	
	
<?php  include_once 'customer/footer.php'; ?>