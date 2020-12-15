<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
include_once 'user-header.php';


	if(isset($_GET['delete'])){
			
			echo '<script> 
					
					$_GET=[];
					window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(a,name,value){$_GET[name]=value;});
					id = $_GET["delete"];
					suspect = $_GET["suspect"];
					
					console.log(suspect);
					
					if(suspect == "order"){
						swal({
						  title: "Delete this order !",
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
													 window.open("orderHistory.php", "_self");	
													 return;
											});
											
										}
										
										
									},
									error: function(ts) { console.log(ts.responseText);
									}
								});
							}else{
							 window.open("orderHistory.php", "_self");	
							}						 
						});
					}
			</script>';

	}




?>

<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header" id='error_shower'>Orders</h3>
	</div> 
</div> <!-- end of first row -->   
			
<div class="row">
    <div class="col-lg-12">
		<div class="table-responsive"> 	
			<table class="table table-bordered" style="margin-top:30px;visibility:hidden" id="table-cart">
					<tr>
						<td class='table-rows-formatter'> </td>
						<th class='table-primary text-center'> Order ID</th>
						<th class='table-primary text-center'> Price </th>
						<th class='table-primary text-center'> Items </th>
						<th class='table-primary text-center'> Date </th>
					</tr>

				<script>


				$(document).ready(function(){
					 
					 $.ajax({
							type:'POST',
							url:'../scripts/foreground/getSpecificUserOrders.php',
							dataType: "json",
							data:{'email':'<?php echo $_SESSION['email']?>'},
							success:function(data){
								
								if ( data['message'][0] == 'none'){
									document.getElementById('error_shower').innerHTML = "No record found";
									document.getElementById("table-cart").style.visibility = "hidden";
								}else{
									document.getElementById("table-cart").style.visibility = "visible";
									console.log(data);
									 len = data['data'].length;
									 counter = 1;
									 for (i=0;i<len;i++) {
										
										  counter += i;
										  d = new Date(parseInt(data['data'][i]['order_date']));
										  date = d.toLocaleString();
										 
										 suspect = "<tr class='table-primary text-center'>"
													+"<td> <a href='orderHistory.php?delete="+data['data'][i]['orderID']+"&&suspect=order'><i class='fa fa-times-circle' style='color:black;font-size:20px;font-weight:bolder'></i></a></td>"
													+"<td>"+data['data'][i]['orderID']+"</td>"
													+"<td>"+data['data'][i]['price']+"</td>"
													+"<td>"+data['data'][i]['items']+"</td>"
													+"<td>"+date+"</td>"
													+"</tr>"
										 
										$("#table-cart").append(suspect);
								 }
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
	include_once 'user-footer.php';
?>