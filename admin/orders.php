<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
include_once 'header.php';
?>

<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">Orders</h3>
	</div> 
</div> <!-- end of first row -->   
			
<div class="row">
    <div class="col-lg-12">
		<div class="table-responsive"> 	
			<table class="table table-bordered" style="margin-top:30px;" id="table-cart">
					<tr>
						<td class='table-rows-formatter'> </td>
						<th class='table-primary text-center'> Order ID </th>
						<th class='table-primary text-center'> User ID </th>
						<th class='table-primary text-center'> User Name </th>
						<th class='table-primary text-center'> User Address </th>
						<th class='table-primary text-center'> Price </th>
						<th class='table-primary text-center'> Order date </th>
						<th class='table-primary text-center'> Items </th>
						
					</tr>

				<script>


				$(document).ready(function(){
					 
					 $.ajax({
							type:'POST',
							url:'../scripts/foreground/getAllOrders.php',
							dataType: "json",
							data:{},
							success:function(data){
									console.log(data);
								 len = data['data'].length;
								 counter = 0;
								 for (i=0;i<len;i++) {
									 source = data['data'][i]['picture'];
									 pointer = "../uploadedImages/"+source;
									
									 d = new Date(parseInt(data['data'][i]['order_date']));
									date = d.toLocaleString();
									 
									 suspect = "<tr class='table-primary text-center'>"
												+"<td> <span class='proChecker' style='cursor:pointer' id="+data['data'][i]['ID']+"><i class='fa fa-times-circle' style='color:black;font-size:20px;font-weight:bolder'></i></span></a></td>"
												+"<td>"+data['data'][i]['ID']+"</td>"
												+"<td>"+data['data'][i]['user_id']+"</td>"
												+"<td>"+data['data'][i]['user_name']+"</td>"
												+"<td>"+data['data'][i]['user_address']+"</td>"
												+"<td> Rs. "+ data['data'][i]['price']+"</td>"
												+"<td> "+date+" </td>"
												+"<td> "+data['data'][i]['items']+" </td>"
												
												+"</tr>"
									 
									$("#table-cart").append(suspect);
							 }
							
								
							
							},
							error: function(ts) { console.log(ts.responseText);
							}
					});
					
					$(document).on('click', '.proChecker', function() {
						id =  $(this).attr('id');
						
						flager = $(this).parent().parent();

						swal({
						  title: "Delete this order !",
						  text: "Customer will also not be able to view it",
						  buttons: ["Cancel", "Delete"],
						}).then(function(value) {
							  console.log(value);
								if(value!=null){
								 $.ajax({
									type:"POST",
									url:"../scripts/foreground/deleteOrder.php",
									dataType: "json",
									data:{"id":id},
									success:function(data){
										console.log(data);
										if(data.error){
											swal("Ooopps",data.message+"", "error");
										}else{
											swal({ 
												   title: "success",
												   text: data.message+"",
												   icon: "success" 
												  }).then(function() {
													  
													 flager.remove();
													  
													 //window.open("products.php", "_self");	
													 return;
											});
											
										}
										
										
									},
									error: function(ts) { console.log(ts.responseText);
									}
								});
							}else{
							// window.open("products.php", "_self");	
							}						 
						});
					});	
					
					
				});
								
								
				 
				</script>
			</table>
		</div>
    </div>  <!-- whole tab-->
				
</div> <!-- end of second row -->
				

</div> <!-- end of first row -->  
        

		
	
<?php
	include_once 'footer.php';
?>