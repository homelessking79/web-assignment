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
<div class="container">
    <div class="row pt-5 pb-5">
        <div class="col-lg-6">
            <div class="image">
            </div>
            <div class="description-wrapper">
                <h3 style="border-bottom: 1px solid silver" class="mb-2">Product Description</h2>
                    <div id="product-desc"></div>
            </div>

        </div>
        <div class="col-lg-6">
            <div style="padding: 20px 0; font-size: 20px; font-weight: 600; border-bottom: 1px solid silver" id="product-name"></div>
            <div style="display: flex; justify-content: flex-start" class="price pt-3 pb-3">
                <span>Price: </span>
                <div id="product-price" style="margin-left: 10px; color: red; font-size: 16px"></div>
            </div>
            <div>
                <div id="policy" style="border-bottom: 1px solid silver; padding-bottom: 40px">
                    <div class="d-flex">
                        <div class="return text-center mr-5">
                            <div class="font-size-20 my-2 color-second">
                                <span class="fa fa-retweet border p-3" style="border-radius: 50% ;font-size: 20px; color: cyan"></span>
                            </div>
                            <a href="#" class="font-rale font-size-12"> 10 Days <br> Replacement</a>
                        </div>
                        <div class="return text-center mr-5">
                            <div class="font-size-20 my-2 color-second">
                                <span class="fa fa-truck border p-3" style="border-radius: 50% ;font-size: 20px; color: cyan"></span>
                            </div>
                            <a href="#" class="font-rale font-size-12"> Daily Tuition <br> Delivery</a>
                        </div>
                        <div class="return text-center mr-5">
                            <div class="font-size-20 my-2 color-second">
                                <span class="fa fa-phone border p-3" style="border-radius: 50% ;font-size: 20px; color: cyan"></span>
                            </div>
                            <a href="#" class="font-rale font-size-12"> 1 Year <br> Waranty</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="add-to-cart pt-3 pb-3">
                <button style="width: 50%; border-radius: 25px; margin: 0 auto" class="btn btn-primary"> Add To Cart</button>
            </div> -->
            <div class="add-to-cart">
                
            </div>

        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        id = JSON.parse(localStorage.getItem('product-id'));
        console.log("ok");
        console.log(id);
        $.ajax({
            type: 'POST',
            url: './scripts/foreground/getProductById.php',
            dataType: "json",
            data: {
                'id': id
            },
            success: function(data) {
                pointer = "./uploadedImages/Product/" + data.data.picture;
                console.log(data);
                name = data.data.name;
                picture = '<img src=" ' + pointer + ' " class="img-fluid  mb-3" style="width: 100%; max-height: 450px; object-fit: cover " alt="IMG">';
                price = `$` + data.data.price;
                description = data.data.description;
                productId = '<button type="submit" class="btn btn-block btn-danger proChecker" name="' + data.data.name + '"id="' + data.data.ID + '"' + '>' + '<span style="font-size:11px">ADD TO CART</span> &nbsp; &nbsp;<i class="fa fa-shopping-cart"></i>' + '</button>';
                // console.log(productID)
    
                $('#product-name').append(name);
                $('#product-price').append(price);
                $('#product-desc').append(description);
                $('.image').append(picture);
                $('.add-to-cart').append(productId);
            }
        });
    });

    $(document).on('click', '.proChecker', function() {
		id = $(this).attr('id');
		name = $(this).attr('name');
		toast = new iqwerty.toast.Toast();
		toast.setText(name + ' added to cart');
		toast.show();

		$.ajax({
			type: 'POST',
			url: "scripts/foreground/addItemToCart_session.php",
			dataType: "json",
			data: {
				'ID': id
			}
		});

	});
    // sum = 0;
</script>











<?php
include "map.php";
?>

<?php include_once 'customer/footer.php'; ?>