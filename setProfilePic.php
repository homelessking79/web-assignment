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
		header('location: index.php');
		exit();
	}
?>

<div class="container h-100" style="margin-top :100px;">
  <h1 class="my-4 text-center text-lg-center ">Welcome <?php echo $_SESSION["name"]?></h1>
  <div class="row h-100 justify-content-center align-items-center">
	<img src="images/user.png" id="profile-img-tag" style="width:280px;height:280px" class="img-fluid rounded-circle mb-3"/>	
  </div>
  <div class="row h-100 justify-content-center align-items-center">
  <form id='uploadProduct' name="former">
		<h6 class="text-center" style="color:grey">Add your profile picture<br>Your profile picture will always be public</h6>
		<div class="form-group pull-right">
		
					<input type="text"	value = '<?php  
									if(isset($_SESSION["email"])) { 
										echo $_SESSION["email"]; 
									}else{
										echo "";
									}
									?>'; hidden name="email">
		
			 <p name=""></p>
			 <input required style="margin-top:20px;"  id='profile-img' type="file" name="image" accept="image/*" />
			 <button id="add_cat" type='submit' class="btn btn-primary">Upload Profile Picture</button>
		</div>    				 
  </form> 
  </div>
</div>

<script>


	 $(document).ready(function(){
		 
		 
		 	email = '<?php  
									if(isset($_SESSION["email"])) { 
										echo $_SESSION["email"]; 
									}else{
										echo "";
									}
									?>';
					 
						$.ajax({
						  type:'POST',
						  url: "scripts/foreground/getProfileAddress.php",
						  dataType: "json",
						  data: { 'email': email},
						    success:function(data){
								
								console.log(data+" hey");
								
								address = data['data']['profile'];
								url = "uploadedImages/"+address;
								if(address != 'none'){
									document.getElementById("profile-img-tag").src= url;
								}else{
									url = "images/user.png";
									document.getElementById("profile-img-tag").src= url;
								}
								
								
								
							},
							error: function(ts) { console.log(ts.responseText);
							}
						});
						
						
		 
				$("#uploadProduct").on('submit',(function(e) {
						e.preventDefault();
						$.ajax({
						url: "scripts/foreground/update_user_profile.php", 
						type: "POST",             
						data: new FormData(this), 
						contentType: false,  
						dataType: "json",						
						cache: false,           
						processData:false,       
						success: function(data)  {
						  
						   len = data['message'].length;
							 suspect = '';
							 for (i=0;i<len;i++) {
								 suspect += data['message'][i] + '\n';
							}
							
							if(data.error){
								
								swal("Ooopps",suspect, "error");
							}else{
								 document.former.reset();
								
								swal({ 
									   title: "Success",
									   text: suspect,
									   icon: "success" 
									  }).then(function() {
										 $('#uploadProduct').trigger("reset");
										  window.open('index.php', '_self');
										 return;
								});  
							} 
						  
						  
						  
						},
						error: function(ts) { console.log(ts.responseText);}
						});
					}));
	 });// jquery parent ends here
	 
	 
	 
	 function readURL(input) {
		if (input.files && input.files[0]) {
			
			imagefile = input.files[0].type;
			match = ["image/jpeg","image/png","image/jpg"];
			if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))) {
				swal("Ooopps",'Please only choose the image file', "error");
				$('#profile-img').val('');
				return;
			}
			
			var reader = new FileReader();
			
			reader.onload = function (e) {
				$('#profile-img-tag').attr('src', e.target.result);
				$('#profile-img-tag').attr('style','width:250px;height:250px');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#profile-img").change(function(){
		readURL(this);
		
	}); 


</script>

	
<?php  include_once 'customer/footer.php'; ?>