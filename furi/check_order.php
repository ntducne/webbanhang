
<?php
session_start();
    include 'config/formatMoney.php';
    include 'control.php';

    if(isset($_GET['order_code'])) {
        $order_code = $_GET['order_code'];
        $orderModel = new Data();
        $orders = $orderModel->readByOrderCode($order_code);
        if($orders->num_rows == 0) {
            $error = 'Order not found';
        }
        else {
            $order = $orders->fetch_assoc();
            $orderDetail = $orderModel->getOrderDetail($order['id']);
        }
    }
    else{
        // alert 
        echo '<script>alert("Please enter order code")</script>';
        echo '<script>window.location.href="index.php"</script>';
    }
    
?>


<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!doctype php>
<php lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="author" content="Untree.co">
        <link rel="shortcut icon" href="/favicon.png">

        <meta name="description" content="" />
        <meta name="keywords" content="bootstrap, bootstrap4" />

        <!-- Bootstrap CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link href="css/tiny-slider.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <title>CQ Store</title>
        <style>
        .card {
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: 1rem;
        }

        .text-reset {
            --bs-text-opacity: 1;
            color: inherit !important;
        }

        a {
            color: #5465ff;
            text-decoration: none;
        }
    </style>
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
        <nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar" style="background-color: #3b5d50 !important;">

            <div class="container">
                <a class="navbar-brand" href="index.php">Furni<span>.</span></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsFurni">
                    <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li><a class="nav-link" href="shop.php">Shop</a></li>
                        <li><a class="nav-link" href="about.php">About us</a></li>
                        <!--                <li><a class="nav-link" href="services.php">Services</a></li>-->
                        <!--                <li><a class="nav-link" href="blog.php">Blog</a></li>-->
                        <li><a class="nav-link" href="contact.php">Contact us</a></li>
                        <li class="active"><a href="check_order.php" class="nav-link">Check Order</a></li>

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


        <div class="product-section">
            <div class="container">
                <div class="container-fluid ps-md-0">
                    <div class="row g-0">
                        <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image">
                            <img src="images/product-2.png" alt="">
                        </div>
                        <div class="col-md-8 col-lg-6">
                            <div class="login d-flex align-items-center py-5">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-9 col-lg-8 mx-auto">
                                            <h3 class="login-heading mb-4">Find Order</h3>

                                            <!-- Sign In Form -->
                                            <form method="GET">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="floatingInput" name="order_code" placeholder="Order Code" required value="<?php echo $order_code ?? '' ?>">
                                                    <label for="floatingInput">Order Code</label>
                                                </div>
                                                <span style="color: red"><?php if(isset($error)) { echo $error; } ?></span>
                                                <div class="mt-3">
                                                    <button type="submit" class="btn btn-sm btn-primary btn-login text-uppercase fw-bold mb-2" name="find_order">Find Order</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <?php if(isset($order_code) && !isset($error)) { ?>

        <!-- End Header/Navigation -->
        <div class="container mt-5" id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Order Detail - #<?php echo $order['order_code'] ?> - <?php echo $order['order_date'] ?></h1>
                        <!-- <h1 class="page-subhead-line"><a href="./create.php" class="btn btn-success">Create</a></h1> -->
                    </div>
                </div>

                <!-- Main content -->
                <div class="row mt-5">
                    <div class="col-lg-8">
                        <!-- Details -->
                        <div class="card mb-4">
                            <div class="card-body" style="padding: 20px !important;">

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $total = 0; foreach ($orderDetail as $item) : $total += $item['price'] ?>
                                            <tr>
                                                <td><p><?php echo $item['name'] ?></p></td>
                                                <td><?php echo $item['quantity'] ?></td>
                                                <td class="text-end"><?php echo formatMoneyVN($item['price']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="text-right font-weight-bold">Subtotal</td>
                                            <td class="text-end"><?php echo formatMoneyVN($total) ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-right font-weight-bold">Shipping</td>
                                            <td class="text-end"><?php echo formatMoneyVN(20000) ?></td>
                                        </tr>
                                        <!-- <tr>
                                            <td colspan="2">Discount (Code: NEWYEAR)</td>
                                            <td class="text-danger text-end">-$10.00</td>
                                        </tr> -->
                                        <tr class="">
                                            <td colspan="2" class="text-right font-weight-bold">TOTAL</td>
                                            <td class="text-end"><?php echo formatMoneyVN($total + 20000) ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- Payment -->
                        <div class="card mb-4" style="margin-top: 20px !important;">
                            <div class="card-body" style="padding: 20px !important;">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h3>Payment Method</h3>
                                        <p><?php echo $order['payment_method'] ?><br>
                                            Total: <?php echo formatMoneyVN($total + 20000) ?> <br> <?php echo $order['status'] ?></p>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4" >
                        <div class="card mb-4">
                            <div class="card-body " style="padding: 20px;">
                                <h3>Customer Notes</h3>
                                <p><?php echo $order['note'] ?></p>
                            </div>
                        </div>
                        <div class="card mb-4" style="margin-top: 20px;">
                            <div class="card-body" style="padding: 20px;">
                                <h3>Shipping Information</h3>
                                <div class="mb-3"><b><?php echo $order['customer_name'] ?></b></div>
                                <div class="mb-2"><?php echo $order['customer_address'] ?></div>
                                <a href="tel:<?php echo $order['customer_phone'] ?>"><?php echo $order['customer_phone'] ?></a> 
                            </div>
                        </div>
                        <div class="card mb-4" style="margin-top: 20px;">
                            <div class="card-body " style="padding: 20px;">
                                <?php echo $order['status'] ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- Start Product Section -->

        <?php }  ?>
        


        
        



        <!-- End Product Section -->
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
                            <p class="mb-2 text-center text-lg-start">Copyright &copy;<script>
                                    document.write(new Date().getFullYear());
                                </script>. All Rights Reserved. &mdash; Designed with love by <a href="https://untree.co">Untree.co</a> Distributed By <a hreff="https://themewagon.com">ThemeWagon</a> <!-- License information: https://untree.co/license/ -->
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

</php>