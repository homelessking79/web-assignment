<?php

if ((function_exists('session_status') && session_status() !== PHP_SESSION_ACTIVE) || !session_id()) {
	session_start();
}

if (isset($_SESSION['isLogin'])) {
	if ($_SESSION['isLogin']) {
		if ($_SESSION['role'] == 'C') {
			include_once 'customer/header-login.php';
		} else if ($_SESSION['role'] == 'A') {
			header('location: admin/products.php');
			exit();
		}
	}
} else {

	include_once 'customer/header.php';
}
?>

<div class="container" style="margin-top:100px">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header" id="shower"></h3>
		</div>
	</div> <!-- end of first row -->

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-bordered" style="margin-top:30px;" id="table-cart">
					<tr>
						<td class='table-rows-formatter'> </td>
						<th class='text-center'> </th>
						<th class='text-center'> Product</th>
						<th class='text-center'> Price </th>
						<th class='text-center'> Quantity </th>
						<th class='text-center'> Total </th>


					</tr>

					<script>
						$(document).ready(function() {

							arrIDs = [];
							theServerResponse = null;
							// sum = 0;

							$.ajax({
								type: 'POST',
								url: './scripts/foreground/getCartItems_session.php',
								dataType: "json",
								data: {},
								success: function(data) {
									//console.log(data);

									if (data['error']) {
										$("#shower").html('Cart is empty');
										document.getElementById("orderNow").style.visibility = "hidden";
										document.getElementById("table-cart").style.visibility = "hidden";
										document.getElementById("updateCart").style.visibility = "hidden";

									} else {
										document.getElementById("orderNow").style.visibility = "visible";
										document.getElementById("updateCart").style.visibility = "visible";
										document.getElementById("table-cart").style.visibility = "visible";
										$("#shower").html('Cart');


										dataLength = data['data'].length;
										//console.log(data['data']);
										subtotal = 0;
										for (i = 0; i < dataLength; i++) {
											//console.log('hereh');
											theServerResponse = data["data"];
											arrIDs.push(data["data"][i]["product_id"]);
											source = data['data'][i]['product_img1'];
											pointer = "./uploadedImages/Product/" + source;

											//console.log(theServerResponse);
											subtotal += parseInt(data['data'][i]['price']);
											//console.log(subtotal + ' - ' + parseInt(data['data'][i]['price']));
											formatter = ' <tr class="text-center"> ' +
												' <td> <span class="proChecker" style="cursor:pointer" id=' + data["data"][i]["product_id"] + ' name=' + data["data"][i]["product_title"] + '><i class="fa fa-times-circle" style="color:black;font-size:20px;font-weight:bolder"></i></span></a></td> ' +
												'	<td> <img src=" ' + pointer + ' " class="img-fluid rounded-circle mb-3" style="width:40px;height:40px" alt="IMG"> </td>'


												+
												'	<td> <strong> ' + data['data'][i]['product_title'] + '</strong> </td>' +
												'	<td> $ ' + data['data'][i]['price'] + ' </td>'

												+
												'<td> <strong style="color:grey">Quantity</strong>  <input id=inputer' + data["data"][i]["product_id"] + ' style="width:50px; border:1px solid #DCDCDC;color:#A9A9A9" type="number" required step="1" min="1" max="" value="1" size="4" pattern="[0-9]*" inputmode="numeric"> </td> ' +
												'	<td id=totalSection' + data["data"][i]["product_id"] + ' class=subtotal	> $' + data['data'][i]['price'] + ' </td>' +
												' </tr>';

											$("#table-cart").append(formatter);


										}
										console.log(theServerResponse);
										sus = '<tr  class="text-center"> <td colspan=5></td><td id="totCartValue">$' + subtotal + '</td></tr>';
										$('#table-cart').find('tr:last').after(sus);
									}





								},
								error: function(ts) {
									console.log(ts.responseText);
								}
							});

							$(document).on('click', '.proChecker', function() {
								id = $(this).attr('id');
								name = $(this).attr('name');

								toast = new iqwerty.toast.Toast();
								toast.setText(name + ' removed from cart');
								toast.show();

								$.ajax({
									type: 'POST',
									url: "./scripts/foreground/removeItemfromCart_session.php",
									dataType: "json",
									data: {
										'ID': id
									},
									error: function(ts) {
										console.log(ts.responseText);
									}
								});

								arrIDs.splice($.inArray(id, arrIDs), 1);
								flager = $(this).parent().parent();
								flager.remove();

								if (arrIDs.length == 0) {
									document.getElementById("orderNow").style.visibility = "hidden";
									document.getElementById("table-cart").style.visibility = "hidden";
									document.getElementById("updateCart").style.visibility = "hidden";
								}


							});


							$('#updateCart').on('click', function() {
								sum = 0;
								price = -99;
								for (i = 0; i < arrIDs.length; i++) {

									//p = getPrice(theServerResponse , arrIDs[i]);
									for (j = 0; j < theServerResponse.length; j++) {
										if (theServerResponse[j]['product_id'] == arrIDs[i]) {
											price = theServerResponse[j]['price'];
										}
									}

									susID = '#inputer' + arrIDs[i];
									totID = '#totalSection' + arrIDs[i];
									susVal = $(susID).val();

									if (parseInt(susVal) < 1) {
										swal("Ooopps", 'Quantity can not be less than 1', "error");
										return;
									}

									mult = parseInt(susVal) * parseInt(price);
									sum += parseInt(mult);
									$(totID).html("$" + mult);
									console.log($(susID).val() + ' value of ' + mult + ' = ' + price);
								}
								// arrTotal = $('.subtotal');
								// console.log(arrTotal[1]);
								// // console.log(document.getElementsByClassName('subtotal'));
								// for(i = 0; i< arrTotal.length; i++){
								// 	sum+= parseInt(arrTotal[i].html);
								// }
								$('#totCartValue').html("$" + sum);


							});

							$('#orderNow').on('click', function() {

								isUserLogin = '<?php
												if (isset($_SESSION["isLogin"])) {
													echo true;
												} else {
													echo false;
												}
												?>';
								console.log(isUserLogin);


								if (!isUserLogin) {

									swal("Ooopps", 'Please create account or log in to place your order', "info");
									return;
								} // if ends here 
								else {

									userEmail = '<?php
													if (isset($_SESSION["email"])) {
														echo $_SESSION["email"];
													} else {
														echo "";
													}
													?>';
									sum = 0;
									price = 0;
									for (i = 0; i < arrIDs.length; i++) {


										for (j = 0; j < theServerResponse.length; j++) {
											if (theServerResponse[j]['ID'] == arrIDs[i]) {
												price = theServerResponse[j]['price'];
											}
										}

										susID = '#inputer' + arrIDs[i];
										totID = '#totalSection' + arrIDs[i];
										susVal = $(susID).val();

										if (parseInt(susVal) < 1) {
											swal("Ooopps", 'Quantity can not be less than 1', "error");
											return;
										}

										mult = parseInt(susVal) * parseInt(price);
										sum += parseInt(mult);


									}

									//console.log(sum);
									$.ajax({
										type: 'POST',
										url: 'scripts/foreground/order.php',
										dataType: "json",
										data: {
											'email': userEmail,
											'ids': arrIDs.toString(),
											'price': sum
										},
										success: function(data) {
											if (data.error) {
												swal("Ooopps", data.message, "error");
											} else {

												swal({
													title: "Congratulations",
													text: data.message,
													icon: "success"
												}).then(function() {

													$.ajax({
														url: "./scripts/foreground/destory_cart_session.php"
													});

													window.open('./orderHistory.php', '_self');
												});
											}
										},
										error: function(ts) {
											console.log(ts.responseText);
										}
									});

								} //else ends here 


							});



						});


						function getPrice(res, id) {
							for (i = 0; i < res.length; i++) {
								if (res[i]['ID'] == id) {
									return res[i]['price'];
								}
							}
							return null;
						}
					</script>
				</table>
			</div>
		</div> <!-- whole tab-->

	</div> <!-- end of second row -->

	<div class="row">
		<div class="col-lg-12">
			<input type="button" class="btn btn-secondary pull-right" id="updateCart" value="Update cart">
			<input type="button" style="margin-right:10px;" class="btn btn-secondary pull-right " id="orderNow" value="Order now">
		</div>
	</div>


	<div class="row">
		<div class="col-lg-12">

			<h3 id="table-cart-total"> </h3>

		</div> <!-- whole tab-->

	</div> <!-- end of second row -->

</div> <!-- end -->


<?php include_once 'customer/footer.php'; ?>