<?php
    include 'config/session.php';
    Session::init();
    include 'config/formatMoney.php';
    include 'config/connect.php';
    include 'control/product.php';
    include 'control/comments.php';
    $comment = new Comment();
    $user = Session::get('authUser');
    $id = $_GET['id'];
    if(isset($_POST['processRate'])) {
        $star = $_POST['star'];
        $review = $_POST['review'];
        $time = date('Y-m-d H:i:s');
        $comment->create($user['name'], $user['image'], $star, $id, $review, $time);
        header('Location: /detail.php?id='.$id);
    }
    $product = new Product();
    $detail = $product->readById($id);
    $detail = $detail->fetch_assoc();
    $comments = $comment->readByProductId($id);
    include 'control/cart.php';
    $cart = new Cart();
    if(isset($_POST['processCart'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $quantity = $_POST['quantity_prd'];
        $cart->add($id, $name, $price, $image, $quantity);
        echo '<script>alert("Product added to cart successfully")</script>';
        header('Location: /detail.php?id='.$id);
    }
    if(isset($_POST['processBuy'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $quantity = $_POST['quantity_prd'];
        $cart->add($id, $name, $price, $image, $quantity);
        header('Location: /checkout.php');
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
        <link rel="shortcut icon" href="favicon.png">

        <meta name="description" content="" />
        <meta name="keywords" content="bootstrap, bootstrap4" />

        <!-- Bootstrap CSS -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link href="/css/tiny-slider.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">
        <title>CQ Store</title>
        <style>
            div.stars {
                /* width: 270px; */
                display: inline-block;
            }
            .mt-200 {
                margin-top: 200px;
            }
            input.star {
                display: none;
            }
            label.star {
                float: right;
                padding: 2px;
                font-size: 20px;
                color: #4A148C;
                transition: all .2s;
            }
            input.star:checked~label.star:before {
                content: '\f005';
                color: #FD4;
                transition: all .25s;
            }
            input.star-5:checked~label.star:before {
                color: #FE7;
                text-shadow: 0 0 20px #952;
            }
            input.star-1:checked~label.star:before {
                color: #F62;
            }
            label.star:hover {
                transform: rotate(-15deg) scale(1.3);
            }
            label.star:before {
                content: '\f006';
                font-family: FontAwesome;
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
                <a class="navbar-brand" href="/">Furni<span>.</span></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsFurni">
                    <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                        <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                        <li><a class="nav-link" href="/shop.php">Shop</a></li>
                        <li><a class="nav-link" href="/about.php">About us</a></li>
                        <!--                <li><a class="nav-link" href="services.php">Services</a></li>-->
                        <!--                <li><a class="nav-link" href="blog.php">Blog</a></li>-->
                        <li><a class="nav-link" href="/contact.php">Contact us</a></li>
                        <li><a href="/check_order.php" class="nav-link">Check Order</a></li>
                        <li class="nav-item active"><a class="nav-link">Product Detail</a></li>

                    </ul>

                    <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                        <li>
                            <a class="nav-link position-relative" href="/cart.php">
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
                                    <li><a class="nav-link" href="/profile.php"><img src="images/user.svg"></a></li>
                                '; 
                            }
                            else {
                                echo '
                                    <li><a class="nav-link" href="/auth/login.php"><img src="images/user.svg"></a></li>
                                ';
                            }
                        ?>
                    </ul>
                </div>
            </div>

        </nav>
        <!-- End Header/Navigation -->

        <!-- Start Product Section -->
        <div class="container mt-5 mb-5" style="max-width: 960px">
            <div class="heading-section mb-5">
                <h2>Product Detail</h2>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <img class="w-100 rounded" src="/uploads/<?= $detail['image'] ?>" />
                </div>
                <form method="post" class="col-md-6">

                    <div class="product-dtl">
                        <div class="product-info">
                            <h1 class="product-name mb-3"><?= $detail['name'] ?></h1>
                            <div class="product-price-discount">
                                <h3><?= formatMoneyVN($detail['price'])  ?></h3>
                            </div>
                        </div>
                        <div class="product-count">
                            <label for="size" class="">Số lượng</label>
                            <input class="form-control w-25" type="number" min="1" step="1" value="1" name="quantity_prd" id="quantity_prd">
                        </div>
                        <div class="mt-3">
                            <input type="hidden" name="id" value="<?php echo $detail['id'] ?>">
                            <input type="hidden" name="name" value="<?php echo $detail['name'] ?>">
                            <input type="hidden" name="price" value="<?php echo $detail['price'] ?>">
                            <input type="hidden" name="image" value="<?php echo $detail['image'] ?>">
                            <input type="submit" name="processCart" class="btn btn-sm" value="Add to cart">
                            <input type="submit" name="processBuy" class="btn btn-sm" value="Buy Now">
                        </div>
                    </div>
                </form>

            </div>
            <!-- tab -->
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link  active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Description</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link " id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Review</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                    <div class="row">
                        <div class="col-md-12">
                        <?= $detail['description'] ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                    <div>
                        <div class="">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="mb-3">Reviews</h4>
                                    <div class="review-block">
                                    <?php foreach($comments as $comment) { ?>
                                        <?php if($comment['status'] == 1) { ?>
                                            <div class="row mb-3">
                                                <div class="col-sm-3 d-flex justify-content-center align-items-center">
                                                    <img width="30" height="30" src="<?php echo $comment['customer_image'] ?>" class="img-rounded">&emsp;
                                                    <div>
                                                        <div class="review-block-name fw-bold"><?php echo $comment['customer_name'] ?></div>
                                                        <div class="review-block-date"><?php echo $comment['time'] ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="review-block-rate">
                                                        <div class="stars">
                                                            <?php for($i = 0; $i < $comment['star']; $i++) { ?>
                                                                <i style="color: #FD4" class="fa-solid fa-star"></i>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="review-block-title"><?php echo $comment['review'] ?></div>
                                                </div>
                                            </div>
                                        <?php } } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($user) { ?>
                    <form method="post" class="mt-5">
                        <div class="mb-3">

                            <div class="stars">
                                <input class="star star-5" id="star-5" type="radio" name="star" value="5"/>
                                <label class="star star-5" for="star-5"></label>
                                <input class="star star-4" id="star-4" type="radio" name="star" value="4" />
                                <label class="star star-4" for="star-4"></label>
                                <input class="star star-3" id="star-3" type="radio" name="star" value="3" />
                                <label class="star star-3" for="star-3"></label>
                                <input class="star star-2" id="star-2" type="radio" name="star" value="2" />
                                <label class="star star-2" for="star-2"></label>
                                <input class="star star-1" id="star-1" type="radio" name="star" value="1" />
                                <label class="star star-1" for="star-1"></label>
                                
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Review</label>
                            <textarea class="form-control" name="review" rows="3"></textarea>
                        </div>
                        <input type="submit" class="btn btn-primary" name="processRate" value="Submit">
                        <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                    </form>
                    <?php } else { ?>
                    <div class="mt-5">
                        <a href="/auth/login.php" class="btn btn-primary">Login to rate</a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- End Product Section -->
        <!-- Start Footer Section -->
        <footer class="footer-section">
            <div class="container relative">

                <div class="sofa-img mt-5">
                    <img src="/images/sofa.png" alt="Image" class="img-fluid">
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="subscription-form">
                            <h3 class="d-flex align-items-center"><span class="me-1"><img src="/images/envelope-outline.svg" alt="Image" class="img-fluid"></span><span>Subscribe to Newsletter</span></h3>

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


        <script src="/js/bootstrap.bundle.min.js"></script>
        <script src="/js/tiny-slider.js"></script>
        <script src="/js/custom.js"></script>
    </body>

</php>