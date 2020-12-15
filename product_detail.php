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
                            console.log(data);
                        }
                    })
                }
                // sum = 0;
    </script>

</div>













<?php include_once 'customer/footer.php'; ?>