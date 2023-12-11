<?php
    session_start();
    ob_start();
?>
<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="css/tiny-slider.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <title>CQ Store</title>
    <style lang="">
        .dropdown {
            margin-top: 9px;
            height: 30px !important;
        }
        .dropdown-toggle {
            background: transparent !important;
            border: none !important;
        }
        .dropdown-toggle::after {
            display: none !important; 
        }
    </style>
</head>

<body>

<!-- Start Header/Navigation -->
<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

    <div class="container">
        <a class="navbar-brand" href="index.php">Furni<span>.</span></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsFurni">
            <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item ">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li><a class="nav-link" href="shop.php">Shop</a></li>
                <li><a class="nav-link" href="about.php">About us</a></li>
<!--                <li><a class="nav-link" href="services.php">Services</a></li>-->
<!--                <li><a class="nav-link" href="blog.php">Blog</a></li>-->
                <li><a class="nav-link" href="contact.php">Contact us</a></li>
                        <li><a href="check_order.php" class="nav-link">Check Order</a></li>
                <li class="active"><a class="nav-link">Checkout</a></li>

            </ul>

            <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                <li>
                    <a class="nav-link position-relative" href="cart.php">
                    <img src="images/cart.svg">
                    <span class="position-absolute mt-2 top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?php
                            if(isset($_SESSION['cart'])){
                                echo count($_SESSION['cart']);
                            }
                            else {
                                echo 0;
                            }
                        ?>
                        <span class="visually-hidden">unread messages</span>
                      </span>
                    </a>
                </li>
                <?php
                    if(isset($_SESSION['authUser'])){
                        echo '
                            <div class="btn-group">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="images/user.svg">
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                    <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                                </ul>
                            </div>
                        '; 
                    }
                    else {
                        echo '
                            <div class="btn-group">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="images/user.svg">
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="login.php">Login</a></li>
                                   
                                </ul>
                            </div>
                        ';
                    }
                ?>

            </ul>
        </div>
    </div>

</nav>
<!-- End Header/Navigation -->

<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Checkout</h1>
                </div>
            </div>
            <div class="col-lg-7">

            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<div class="untree_co-section">
    <div class="container">
        <!-- <div class="row mb-5">
            <div class="col-md-12">
                <div class="border p-4 rounded" role="alert">
                    Returning customer? <a href="#">Click here</a> to login
                </div>
            </div>
        </div> -->

        <?php 
            include 'control.php';
            include 'config/cart.php';
            include 'config/formatMoney.php';
            $user = $_SESSION['authUser'] ?? null;
            $user_id = $user['id'] ?? null;
        
            $cart = new Cart();
            $order = new Data();
        
            if(isset($_GET['id'])){
                $id = $_GET['id'];
                if($order->checkExitProduct($id) == 0){
                    echo '<script>alert("Product is temporarily out of stock !")</script>';
                    header('Location: shop.php');
                }
                else {
                    $product = $order->read_product_by_id($id);
                    $product = mysqli_fetch_assoc($product);
                    $product_id = $product['id'];
                    $product_name = $product['name'];
                    $product_price = $product['price'];
                    $product_image = $product['image'];
                    $product_quantity = 1;
                    $product = [
                        'id_prd' => $product_id,
                        'name_prd' => $product_name,
                        'price_prd' => $product_price,
                        'image_prd' => $product_image,
                        'quantity_prd' => $product_quantity
                    ];
                }
            }
        
            $arrCart = [];
            if(isset($_SESSION['cart'])){
                foreach($_SESSION['cart'] as $key => $value ) {
                    $arrCart[] = $value;
                }
            }
            if(count($arrCart) == 0 && !isset($product)){
                echo '<script>window.location.href="shop.php"</script>';
            }
        ?>


        <form method="post">
            <div class="row">
                <div class="col-md-6 mb-5 mb-md-0">
                    <h2 class="h3 mb-3 text-black">Billing Details</h2>
                    <div class="p-3 p-lg-5 border bg-white">
                        <div class="form-group row mb-3">
                            <div class="col-md-12">
                                <label for="customer_name" class="text-black">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Full name" value="<?php echo $user['name'] ?? '' ?>">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-12">
                                <label for="customer_addresss" class="text-black">Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="customer_addresss" name="customer_addresss" placeholder="Address" value="<?php echo $user['address'] ?? '' ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_email" class="text-black">Email Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="customer_email" name="customer_email" value="<?php echo $user['email'] ?? '' ?>"  placeholder="Email">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="customer_phone" class="text-black">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="customer_phone" name="customer_phone" placeholder="Phone Number" value="<?php echo $user['phone'] ?? '' ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="order_note" class="text-black">Order Notes</label>
                            <textarea name="order_note" id="order_note" cols="30" rows="5" class="form-control" placeholder="Write your notes here..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-3 mt-2">
                        <div class="col-md-12">
                            <h2 class="h3 text-black">Your Order</h2>
                            <div class="p-3 border bg-white">
                                <table class="table site-block-order-table mb-5">
                                    <thead>
                                    <th>Product</th>
                                    <th>Total</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(isset($_SESSION['cart'])){
                                            $total = 0;
                                            foreach($arrCart as $key => $value) {
                                                $total += $value['price_prd'] * $value['quantity_prd'];
                                                echo '
                                                    <tr>
                                                        <td><img width="50" class="rounded" src="../uploads/'.$value['image_prd'].'"/> '.$value['name_prd'].' <strong class="mx-2">x</strong> '.$value['quantity_prd'].'</td>
                                                        <td>'.formatMoneyVN($value['price_prd'] * $value['quantity_prd']).'</td>
                                                    </tr>';
                                            }
                                        }
                                        else {
                                            echo '
                                                <tr>
                                                    <td><img width="50" class="rounded" src="../uploads/'.$product['image_prd'].'"/> '.$product['name_prd'].' <strong class="mx-2">x</strong> '.$product['quantity_prd'].'</td>
                                                    <td>'.formatMoneyVN($product['price_prd'] * $product['quantity_prd']).'</td>
                                                </tr>
                                            ';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                

                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h2 class="h3 mb-3 text-black">Payment Method</h2>
                            <div class="p-3 border bg-white">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="bankTransfer" value="bankTransfer" checked>
                                <label class="form-check-label" for="bankTransfer">
                                    Direct Bank Transfer
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="chequePayment" value="chequePayment">
                                <label class="form-check-label" for="chequePayment">
                                    Cheque Payment
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                                <label class="form-check-label" for="paypal">
                                    Paypal
                                </label>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <a href="cart.php" class="btn btn-primary btn-block">Cart</a>
                        </div>
                        <div class="col-md-4">
                            <input type="submit" class="btn btn-primary btn-block" value="Place Order" name="processOrder">
                            <!-- <button class="btn btn-primary btn-block" onclick="window.location.href='order.php'">Place Order</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </form>


        <?php 
             if(isset($_POST['processOrder'])){
                $customer_name = $_POST['customer_name'];
                $customer_addresss = $_POST['customer_addresss'];
                $customer_email = $_POST['customer_email'];
                $customer_phone = $_POST['customer_phone'];
                $order_note = $_POST['order_note'];
                $payment_method = $_POST['payment_method'];
                $order_status = 0;
                $order_date = date('Y-m-d H:i:s');
                $order_total = 0;
                foreach($arrCart as $key => $value) {
                    $order_total += ($value['price_prd'] * $value['quantity_prd']);
                }
                $order_total += 20000;
                $order_code = time();
                if($user_id !== null){
                    $orderSuccess = $order->insert_order($user_id, $order_code, $customer_name, $customer_addresss, $customer_email, $customer_phone, $order_note, $payment_method, $order_status, $order_date, $order_total);
                }
                else {
                    $orderSuccess = $order->insert_order_2($order_code, $customer_name, $customer_addresss, $customer_email, $customer_phone, $order_note, $payment_method, $order_status, $order_date, $order_total);
                }
                $orderID = $order->readByOrderCode($order_code);
                $orderID = mysqli_fetch_assoc($orderID);
                if(!isset($_SESSION['cart'])){
                    $data = new Data();
                    if($data->checkExitProduct($product['id_prd']) == 0){
                        echo '<script>alert("Product is temporarily out of stock !")</script>';
                        echo '<script>window.location.href="shop.php"</script>';

                        // header('Location: shop.php');
                    }
                    else {
                        $order->insert_order_detail($product['id_prd'], $orderID['id'], $product['name_prd'], $product['quantity_prd'], $product['price_prd']);
                    }
                }
                else {
                    foreach($arrCart as $key => $value) {
                        $order_id = $orderID['id'];
                        $product = $value['id_prd'];
                        $product_name = $value['name_prd'];
                        $product_price = $value['price_prd'];
                        $product_quantity = $value['quantity_prd'];
                        $data = new Data();
                        if($data->checkExitProduct($product) >= 1){
                            $order_detail = $order->insert_order_detail($product, $order_id, $product_name, $product_quantity, $product_price);
                        }
                    }
                    unset($_SESSION['cart']);
                }
                echo "<script>alert('Order success')</script>";
                echo '<script>window.location.href="thankyou.php?order_code=$order_code"</script>';
            }
        ?>
    </div>
</div>

<!-- Start Footer Section -->
<footer class="footer-section">
    <div class="container relative">

        <div class="sofa-img">
            <img src="images/sofa.png" alt="Image" class="img-fluid">
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="subscription-form">
                    <h3 class="d-flex align-items-center"><span class="me-1"><img src="images/envelope-outline.svg" alt="Image" class="img-fluid"></span><span>Subscribe to Newsletter</span></h3>

                    <form action="#" class="row g-3">
                        <div class="col-auto">
                            <input type="text" class="form-control" placeholder="Enter your name">
                        </div>
                        <div class="col-auto">
                            <input type="email" class="form-control" placeholder="Enter your email">
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary">
                                <span class="fa fa-paper-plane"></span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="row g-5 mb-5">
            <div class="col-lg-4">
                <div class="mb-4 footer-logo-wrap"><a href="#" class="footer-logo">Furni<span>.</span></a></div>
                <p class="mb-4">Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate velit imperdiet dolor tempor tristique. Pellentesque habitant</p>

                <ul class="list-unstyled custom-social">
                    <li><a href="#"><span class="fa fa-brands fa-facebook-f"></span></a></li>
                    <li><a href="#"><span class="fa fa-brands fa-twitter"></span></a></li>
                    <li><a href="#"><span class="fa fa-brands fa-instagram"></span></a></li>
                    <li><a href="#"><span class="fa fa-brands fa-linkedin"></span></a></li>
                </ul>
            </div>

            <div class="col-lg-8">
                <div class="row links-wrap">
                    <div class="col-6 col-sm-6 col-md-3">
                        <ul class="list-unstyled">
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Contact us</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-sm-6 col-md-3">
                        <ul class="list-unstyled">
                            <li><a href="#">Support</a></li>
                            <li><a href="#">Knowledge base</a></li>
                            <li><a href="#">Live chat</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-sm-6 col-md-3">
                        <ul class="list-unstyled">
                            <li><a href="#">Jobs</a></li>
                            <li><a href="#">Our team</a></li>
                            <li><a href="#">Leadership</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-sm-6 col-md-3">
                        <ul class="list-unstyled">
                            <li><a href="#">Nordic Chair</a></li>
                            <li><a href="#">Kruzo Aero</a></li>
                            <li><a href="#">Ergonomic Chair</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <div class="border-top copyright">
            <div class="row pt-4">
                <div class="col-lg-6">
                    <p class="mb-2 text-center text-lg-start">Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved. &mdash; Designed with love by <a href="https://untree.co">Untree.co</a> Distributed By <a hreff="https://themewagon.com">ThemeWagon</a>  <!-- License information: https://untree.co/license/ -->
                    </p>
                </div>

                <div class="col-lg-6 text-center text-lg-end">
                    <ul class="list-unstyled d-inline-flex ms-auto">
                        <li class="me-4"><a href="#">Terms &amp; Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>

            </div>
        </div>

    </div>
</footer>
<!-- End Footer Section -->


<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/custom.js"></script>
</body>

</html>
