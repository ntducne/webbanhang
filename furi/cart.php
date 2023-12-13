<?php
include 'control.php';
include 'config/cart.php';
include 'config/formatMoney.php';
session_start();
$product = new Data();
$products = $product->select_product();
$cart = new Cart();

$arrCart = [];
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        $arrCart[] = $value;
    }
}

if (isset($_POST['updateCart']) && $_POST['updateCart'] == 'Update Cart') {
    $id_prd = $_POST['id_prd'];
    $quantity_prd = $_POST['quantity-amount'];
    $data = new Data();

    // Kiểm tra số lượng sản phẩm trong kho
    foreach ($id_prd as $key => $value) {
        if ($data->checkExitProduct($value) < $quantity_prd[$key]) {
            echo '<script>alert("Số lượng sản phẩm có ID ' . $value . ' trong kho không đủ")</script>';
            header('location: cart.php');
            exit();
        }
    }

    // Cập nhật giỏ hàng
    foreach ($id_prd as $key => $value) {
        $newQuantity = $quantity_prd[$key];
        $cart->updateQty($value, $newQuantity);

        // Xóa sản phẩm nếu số lượng mới là 0 hoặc âm
        if ($newQuantity <= 0) {
            $cart->delete($value);
        }
    }

    // Chuyển hướng sau khi cập nhật giỏ hàng
    header('location: cart.php');
    exit();
}


if (isset($_POST['deleteItemCart'])) {
    $cart->delete($_POST['itemDelete']);
    header('location:cart.php');
}

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
                    <li class="active"><a class="nav-link">Cart</a></li>

                </ul>

                <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                    <li>
                        <a class="nav-link position-relative" href="cart.php">
                            <img src="images/cart.svg">
                            <span class="position-absolute mt-2 top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php
                                if (isset($_SESSION['cart'])) {
                                    echo count($_SESSION['cart']);
                                } else {
                                    echo 0;
                                }
                                ?>
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </a>
                    </li>
                    <?php
                    if (isset($_SESSION['authUser'])) {
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
                    } else {
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
                        <h1>Cart</h1>
                    </div>
                </div>
                <div class="col-lg-7">

                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->



    <div class="untree_co-section before-footer-section">
        <div class="container">
            <form class="col-md-12" method="post">
                <div class="row mb-5">
                    <div class="site-blocks-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">Image</th>
                                    <th class="product-name">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-total">Total</th>
                                    <th class="product-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($arrCart as $key => $value) : ?>
                                    <input type="hidden" name="id_prd[]" value="<?php echo $value['id_prd'] ?>">
                                    <tr>
                                        <td class="product-thumbnail">
                                            <img src="../uploads/<?php echo $value['image_prd'] ?>" alt="Image" class="img-fluid">
                                        </td>
                                        <td class="product-name">
                                            <h2 class="h5 text-black"><?php echo $value['name_prd'] ?></h2>
                                        </td>
                                        <td><?php echo formatMoneyVN($value['price_prd']) ?></td>
                                        <td>
                                            <div class="input-group mb-3 d-flex justify-content-start align-items-center quantity-container mx-auto" style="max-width: 120px;">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-outline-black decrease" type="button">&minus;</button>
                                                </div>
                                                <input type="text" class="form-control text-center rounded-pill quantity-amount" name="quantity-amount[]" value="<?php echo $value['quantity_prd'] ?>" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-black increase" type="button">&plus;</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo formatMoneyVN($value['price_prd'] * $value['quantity_prd']) ?></td>
                                        <td>
                                            <input type="hidden" name="itemDelete" value="<?php echo $value['id_prd'] ?>">
                                            <input type="submit" class="btn btn-black btn-sm" value="X" name="deleteItemCart">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (count($arrCart) == 0) : ?>
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            No Product In Cart
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-5">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <?php if (count($arrCart) > 0) : ?>

                                    <input type="submit" class="btn btn-black btn-sm btn-block" value="Update Cart" name="updateCart">
                                <?php endif; ?>
                                <!--                            <button class="btn btn-black btn-sm btn-block">Update Cart</button>-->
                            </div>
                            <!--                        <div class="col-md-6">-->
                            <!--                            <button class="btn btn-outline-black btn-sm btn-block">Continue Shopping</button>-->
                            <!--                        </div>-->
                        </div>
                        <!--                    <div class="row">-->
                        <!--                        <div class="col-md-12">-->
                        <!--                            <label class="text-black h4" for="coupon">Coupon</label>-->
                        <!--                            <p>Enter your coupon code if you have one.</p>-->
                        <!--                        </div>-->
                        <!--                        <div class="col-md-8 mb-3 mb-md-0">-->
                        <!--                            <input type="text" class="form-control py-3" id="coupon" placeholder="Coupon Code">-->
                        <!--                        </div>-->
                        <!--                        <div class="col-md-4">-->
                        <!--                            <button class="btn btn-black">Apply Coupon</button>-->
                        <!--                        </div>-->
                        <!--                    </div>-->
                    </div>
                    <div class="col-md-6 pl-5">
                        <div class="row justify-content-end">
                            <div class="col-md-7">
                                <?php if (count($arrCart) > 0) : ?>

                                    <div class="row">
                                        <div class="col-md-12 text-right border-bottom mb-3">
                                            <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <span class="text-black">Total</span>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <strong class="text-black">
                                                <?php
                                                $total = 0;
                                                foreach ($arrCart as $key => $value) {
                                                    $total += $value['price_prd'] * $value['quantity_prd'];
                                                }
                                                echo formatMoneyVN($total);
                                                ?>
                                            </strong>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="order.php" class="btn btn-black btn-lg py-3 btn-block">Proceed To Checkout</a>
                                        </div>
                                    </div>
                                <?php endif; ?>


                            </div>
                        </div>
                    </div>
                </div>
            </form>
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

</html>