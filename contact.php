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
	
	
?>

    <!-- FORM -->
    <section class="testimonials text-center bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="signup-form">	
			  <form name="former">
				 <h4>We love to hear from our customers</h4>
				 <div class="form-group">
					<input type="text" class="form-control" name="username" placeholder="Full Name" required="required">
				 </div>
				  <div class="form-group">
					<input type="email" class="form-control" name="email"  placeholder="Email Address">
				 </div>
				 <div class="form-group">
					<input type="text" class="form-control" name="subject" placeholder="subject" required="required">
				 </div>
				   
				<div class="form-group">
					<textarea style="resize: none;" class="form-control" rows="8" name="message" placeholder="Message" required="required"></textarea>
				 </div>     				 
				 <div class="form-group">
					<button type="button" id="sendMessage" class="btn btn-primary btn-block btn-lg">Send Message</button>
				 </div>

				</form>
				
			</div>
			
			
          </div><!-- CONTENT -->
		  <div class="col-lg-2">
		  </div>
		<div class="col-lg-4 features-icons bg-light" style="padding:22px 0px 0px 0px">
          <div class="col-lg-12">
            <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
               <i class="fa fa-home  m-auto "></i>
              </div>
              <h5>Visit us</h5>
              <p class="lead mb-0">Jadoon Plaza Phase 2  Abbottabad</p>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
                 <i class="fa fa-phone m-auto "></i>
              </div>
              <h5>Call us</h5>
              <p class="lead mb-0">0992-3847887</p>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="features-icons-item mx-auto mb-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
                <i class="fa fa-envelope m-auto "></i>
              </div>
              <h5>Drop a mail</h5>
              <p class="lead mb-0">support@broastnburger.com</p>
            </div>
          </div>
        </div>
		
		
        </div><!-- row -->
      </div><!-- container -->
    </section>
	
	
	


	<script>
			
			$(document).ready(function(){
		
				 $('#sendMessage').on('click',function(){
					 
					errors = new Array();
					
					name = document.former.username.value.trim();
					email = document.former.email.value.trim();
					subject = document.former.subject.value.trim();
					message = document.former.message.value.trim();
					
					
					if(!name || !email || !subject || !message ){
						errors.push("Please provide all fields");
					}else {
						if(!isString(name)){
							errors.push("Please provide valid name");
						}
						if(!isValidEmail(email)){
							errors.push("Please provide valid email address");
						}
					}
			
					if(errors.length > 0){
						text = "";
						for(i=0;i<errors.length;i++){
							text += errors[i]+"\n";
						}
						swal({
							title: "Oopps",
							text: text,
							icon: "error",
						});
						return;
					}
					
					 $.ajax({
						type:'POST',
						url:'scripts/foreground/contact-us.php',
						dataType: "json",
						data:{'name':name, 'email':email , 'subject':subject , 'message':message},
						success:function(data){
							if(data.error){
								swal("Ooopps",data.message, "error");
							}else{
							    document.former.reset();		
								swal({ 
									   title: "Congratulations",
									   text: data.message,
									   icon: "success" 
									  });
							} 
						},
						error: function(ts) { console.log(ts.responseText);}
					});
					
					
					
					
				});
				
				function isValidEmail(email){
					atpos = email.indexOf("@");
					dotpos = email.lastIndexOf(".");
					if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) {
						return false;
					}
					return true;
				}
				
				function isString(userTEXT){
					for( i=0; i < userTEXT.length; i++){
						if ( !( userTEXT.charAt(i) >= 'a' && userTEXT.charAt(i) <= 'z') && !( userTEXT.charAt(i) >= 'A' && userTEXT.charAt(i) <= 'Z') && !(userTEXT.charAt(i) == ' ' )) {
							return false;
						}
					} // loop ending here
					return true;
				}
			
			});

			
		</script>
			
<?php  
  include "map.php";
?>


<?php 

 include_once 'customer/footer.php';

?>