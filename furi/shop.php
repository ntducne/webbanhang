<?php
    session_start();
    ob_start();
    include 'config/formatMoney.php';
   
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
                <li class="active"><a class="nav-link" href="shop.php">Shop</a></li>
                <li><a class="nav-link" href="about.php">About us</a></li>
<!--                <li><a class="nav-link" href="services.php">Services</a></li>-->
<!--                <li><a class="nav-link" href="blog.php">Blog</a></li>-->
                <li><a class="nav-link" href="contact.php">Contact us</a></li>
                        <li><a href="check_order.php" class="nav-link">Check Order</a></li>
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
                    <h1>Shop</h1>
                </div>
            </div>
            <div class="col-lg-7">

            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->



<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row">

        <?php 
            include 'control.php';
            $product = new Data();
            $products = $product->select_product();
        ?>
        <?php foreach ($products as $product) { ?>

            <!-- Start Column 2 -->
            <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                <div class="product-item">
                    <a href="order.php?id=<?php echo $product['id'] ?>" style="text-decoration: none">
                        <img src="../uploads/<?php echo $product['image'] ?>" class="img-fluid product-thumbnail">
                        <h3 class="product-title"><?php echo $product['name'] ?></h3>
                        <strong class="product-price"><?php echo formatMoneyVN($product['price']) ?></strong>
                    </a>
                    <form method="post">
                        <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                        <input type="hidden" name="name" value="<?php echo $product['name'] ?>">
                        <input type="hidden" name="price" value="<?php echo $product['price'] ?>">
                        <input type="hidden" name="image" value="<?php echo $product['image'] ?>">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="action" value="add">
                        <button class="icon-cross" type="submit">
                            <img src="images/cross.svg" class="img-fluid">
                        </button>
                    </form>
                </div>
            </div>
            <!-- End Column 2 -->
            <?php }
                include 'config/cart.php';
                $cart = new Cart();
                if(isset($_POST['action']) && $_POST['action'] == 'add'){
                    $id = $_POST['id'];
                    $itemData = new Data();
                    if($itemData->checkExitProduct($id) == 0){
                        echo '<script>alert("Product out of stock")</script>';
                        echo '<script>window.location.href="index.php"</script>';   
                    } else {
                        if($itemData->checkExitProduct($id) < $_POST['quantity']){
                            echo '<script>alert("Product out of stock")</script>';
                            echo '<script>window.location.href="index.php"</script>';   
                        }else {
                            $name = $_POST['name'];
                            $price = $_POST['price'];
                            $image = $_POST['image'];
                            $quantity = $_POST['quantity'];
                            $cart->add($id, $name, $price, $image, $quantity);
                            echo '<script>alert("Product added to cart ")</script>';
                            echo '<script>window.location.href="index.php"</script>';
                        }
                    }
                }
            ?>

        </div>
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
                    <p class="mb-2 text-center text-lg-start">Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved. &mdash; Designed with love by <a href="https://untree.co">Untree.co</a>  Distributed By <a href="https://themewagon.com">ThemeWagon</a> <!-- License information: https://untree.co/license/ -->
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
