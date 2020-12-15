<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
include_once 'header.php';

?>

<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">Users</h3>
		<div style="margin-bottom:20px" class="pull-right gallery_item ">
			<button class="btn btn-block btn-success" type='button' id='addProduct'><span style="font-size:11px">ADD NEW MANAGER</span> &nbsp; &nbsp;<i class="fa fa-plus"></i></button>
		</div>	
	</div> 
</div> <!-- end of first row -->   
			
<div class="row">
    <div class="col-lg-12">
		<div class="table-responsive"> 	
			<table class="table table-bordered" style="margin-top:30px;" id="table-cart">
					<tr>
						<th class='table-primary text-center'> ID</th>
						<th class='table-primary text-center'> Name </th>
						<th class='table-primary text-center'> Email </th>
						<th class='table-primary text-center'> Address </th>
						<th class='table-primary text-center'> Role </th>
					</tr>

				<script>


				$(document).ready(function(){
					  $('#addProduct').on('click',function(){
						 window.location.assign("addManager.php");
					 });
					 
					 $.ajax({
							type:'POST',
							url:'../scripts/foreground/getAllUsers.php',
							dataType: "json",
							data:{},
							success:function(data){
									console.log(data);
								 len = data['data'].length;
								 counter = 0;
								 for (i=0;i<len;i++) {
									 
									 suspect = "<tr class='table-primary text-center'>"
												+"<td>"+data['data'][i]['ID']+"</td>"
												+"<td>"+data['data'][i]['name']+"</td>"
												+"<td>"+data['data'][i]['email']+"</td>"
												+"<td>"+data['data'][i]['address']+"</td>"
												+"<td>"+data['data'][i]['role']+"</td>"
												+"</tr>"
									 
									$("#table-cart").append(suspect);
							 }
							
								
							
							},
							error: function(ts) { console.log(ts.responseText);
							}
					});
				});
								
								
				 
				</script>
			</table>
		</div>
    </div>  <!-- whole tab-->
				
</div> <!-- end of second row -->
				
</div> <!-- end of second row -->
        

		
	
<?php
	include_once 'footer.php';
?>