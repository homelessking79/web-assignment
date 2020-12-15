<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
include_once 'header.php';

?>

<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">Messages</h3>
	</div> 
</div> <!-- end of first row -->   

			
<div class="row">
    <div class="col-lg-12">
		<div class="table-responsive"> 	
			<table class="table table-bordered" style="margin-top:30px;" id="table-cart">
					<tr>
						<th class='table-primary text-center'> ID </th>
						<th class='table-primary text-center'> Name </th>
						<th class='table-primary text-center'> Email </th>
						<th class='table-primary text-center'> Subject </th>
						<th class='table-primary text-center'> Message </th>
						<th class='table-primary text-center'> Time </th>
					</tr>

				<script>


				$(document).ready(function(){
					 
					 $.ajax({
							type:'POST',
							url:'../scripts/foreground/getAllMessages.php',
							dataType: "json",
							data:{},
							success:function(data){
									console.log(data);
								 len = data['messages'].length;
								 counter = 0;
								 for (i=0;i<len;i++) {
									
									 d = new Date(parseInt(data['messages'][i]['order_date']));
									 date = d.toLocaleString();
									 
									 suspect = "<tr class='table-primary text-center'>"
										+"<td>"+data['messages'][i]['ID']+"</td>"
										+"<td>"+data['messages'][i]['name']+"</td>"
										+"<td>"+data['messages'][i]['email']+"</td>"
										+"<td>"+data['messages'][i]['subject']+"</td>"
										+"<td>"+data['messages'][i]['message']+"</td>"
										+"<td> Rs. "+ date+"</td>"
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
				

</div> <!-- end of first row -->  
        


<?php
	include_once 'footer.php';
?>