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

require_once 'scripts/background/_DBConnect.php';
$db = new DbConnect();
$con = $db->connect();
?>

<div id="demo" class="carousel slide" data-ride="carousel">

  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>

  <!-- The slideshow -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/slide_1.jpg" alt="">
    </div>
    <div class="carousel-item">
      <img src="img/slide_2.jpg" alt="">
    </div>

  </div>

  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>

</div>


<!-- Icons Grid -->
<section class="features-icons bg-light text-center">
  <div class="container">
    <h1 class="my-4 text-center text-lg-center ">How we work !</h1>
    <div class="row">
      <div class="col-lg-4">
        <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
          <div class="features-icons-icon d-flex">
            <i class="fa fa-retweet m-auto"></i>
          </div>
          <h3>10 Days Replacement</h3>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
          <div class="features-icons-icon d-flex">
            <i class="fa fa-car m-auto "></i>
          </div>
          <h3>Daily Tuition Delivery</h3>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <div class="features-icons-icon d-flex">
          <i class="fa fa-check-circle m-auto"></i>
          </div>
          <h3>1 Year Warranty</h3>
        </div>
      </div>
    </div>
  </div>
</section>





<!---- Image Gallery---->
<div class="container" style="margin-top:100px;">
  <h1 class="my-4 text-center text-lg-center"></h1>
  <h2 class="mb-5 text-center">Trending this month</h2>
  <div class="row" id="body-content-deals">

    <?php
    $result = $con->query("SELECT p.product_id , p.product_title , p.price , p.product_img1 from products p where p.trending = '1'  LIMIT 4");
    while ($row = $result->fetch_assoc()) {
    ?>

      <div class="col-sm-6 col-md-4 col-lg-3 mb-4 gallery_item">
        <div class="card mx-auto text-center image">
          <img class="card-img-top" src="<?php echo "uploadedImages/Product/" . $row['product_img1'] ?>" alt="">
          <div class="card-body">
            <h5 class="card-title"><?php echo $row['product_title'] ?></h5>
            <h5 style="color:red">$<?php echo $row['price'] ?></h5>
          </div>
        </div>
        <div class="middle">
          <button type="submit" class="btn btn-block btn-danger proChecker" name='<?php echo $row['product_title'] ?>' id='<?php echo $row['product_id'] ?>'>
            <span style="font-size:11px">ADD TO CART</span> &nbsp; &nbsp;<i class="fa fa-shopping-cart"></i>
          </button>
        </div>
      </div>
    <?php
    }
    ?>

    <script>
      $(document).on('click', '.proChecker', function() {
        id = $(this).attr('id');
        name = $(this).attr('name');
        toast = new iqwerty.toast.Toast();
        toast.setText(name + ' added to cart');
        toast.show();

        $.ajax({
          type: 'POST',
          url: "./scripts/foreground/addItemToCart_session.php",
          dataType: "json",
          data: {
            'ID': id
          }
        });
      });
    </script>




  </div>
</div>
<div class="container text-center mb-4">
  <a href="./products.php"><button class="btn btn-primary" style="font-size: 20px;">See all products</button></a>
</div>



<!-- Call to Action -->
<section class="call-to-action text-white text-center">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-xl-9 mx-auto">
        <h2 class="mb-4">Ready to get started? Sign up now!</h2>
      </div>
      <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
        <form action="registration.php" method='post'>
          <div class="form-row">
            <div class="col-12 col-md-9 mb-2 mb-md-0">
              <input type="email" name='email' class="form-control form-control-lg" placeholder="Enter your email">
            </div>
            <div class="col-12 col-md-3">
              <button type="submit" name='call_to_action_button' class="btn btn-block btn-lg btn-primary">Sign up</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>



<?php

include_once 'customer/footer.php';

?>