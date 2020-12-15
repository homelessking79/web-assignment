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
			
         
<div class="col-lg-5 col-md-5 col-sm-5">
          <form name='cform' id="former">
			 <h4 id="suspecter"></h4>
			 <div class="form-group">
				<input type="text" class="form-control" name="cname" placeholder="Category Name">
			 </div>    				 
			 <div class="form-group">
				<button id="add_cat" type='button' class="btn btn-primary pull-right">Update Category</button>
			 </div>
		 </form>          </div> <!-- end of tab 2 -->
				
</div> <!-- end of third row -->
        
		
<script>
			
		$(document).ready(function(){
			
			id = localStorage.getItem('suspectID');
			name = localStorage.getItem('suspectName');
			
			document.getElementById('suspecter').innerHTML = "Edit Category <br><br> Name : "+name+" <br> ID : "+id +" <br><br>";
			
			 $('#add_cat').on('click',function(){
					cat_name = document.cform.cname.value.trim();
					console.log(cat_name);
					 $.ajax({
						type:'POST',
						url:'../scripts/foreground/edit_category.php',
						dataType: "json",
						data:{'cat':cat_name,'id':id},
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
									   title: "Success",
									   text: suspect,
									   icon: "success" 
								}).then(function() {
									     $('#former').trigger("reset");
										 window.open('products.php', '_self');
										 return;
								});
							} 
						},
						error: function(ts) { console.log(ts.responseText);}
				}); // ajax calls ends here	
								
			}); // button onclick ends here 
			
		});
					
</script>

<?php
	include_once 'footer.php';
?>