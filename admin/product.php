<?php
session_start();
    include "control.php";
    if(!isset($_SESSION['authUser'])){
        header('Location: /admin/login.php');
    }
    $user = $_SESSION['authUser'];
    $username = $user['username'];
    $name = $user['name'];
    $image = $user['image'];
    $product = new Data();
    $category = new Data();
    $products = $product->product_read();
    if (isset($_POST['deleteProduct'])) {
        // delete image
        $productDetail = $product->product_readById($_POST['id']);
        $productDetail = mysqli_fetch_object($productDetail);
        unlink("../uploads/".$productDetail->image);
        $id = $_POST['id'];
        $product->product_delete($id);
        // get item cart
        $cart = $_SESSION['cart'];
        if(!$cart) {
            $_SESSION['cart'] = [];
            header('Location: product.php');
        }
        $cart = array_filter($cart, function ($item) use ($id) {
            return $item['id_prd'] != $id;
        });
        $_SESSION['cart'] = $cart;
        header('Location: product.php');
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>CQ Store - Admin</title>
<link rel="shortcut icon" href="/favicon.png">

    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet"/>
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet"/>
    <!--CUSTOM BASIC STYLES-->
    <link href="assets/css/basic.css" rel="stylesheet"/>
    <!--CUSTOM MAIN STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet"/>
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
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
<div id="wrapper">
    <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/admin/">CQ Store</a>
        </div>

        <div class="header-right">
            <a href="/admin/logout.php" class="btn btn-danger" title="Logout"><i class="fa fa-exclamation-circle fa-2x"></i></a>



        </div>
    </nav>
    <!-- /. NAV TOP  -->
    <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">
                <li>
                    <div class="user-img-div">
                        <img src="/uploads/<?php echo $image ?>" class="img-thumbnail" />
                        <div class="inner-text"><?php echo $name ?><br /></div>
                    </div>

                </li>


                <li><a href="/admin/">Dashboard</a></li>
                <li><a href="/admin/category.php">Category </a></li>
                <li><a class="active-menu" href="/admin/product.php">Product </a></li>
                <li><a href="/admin/user.php">User </a></li>
                <li><a href="/admin/order.php">Order </a></li>


            </ul>
        </div>

    </nav>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper">
        <div id="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">Product</h1>
                    <h1 class="page-subhead-line"><a href="product_create.php" class="btn btn-success">Create</a></h1>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['id'] ?></td>
                            <td><img  src="/uploads/<?php echo $product['image'] ?>" width="100px" height="100px"/>
                            </td>
                            <td><?php echo $product['name'] ?></td>
                            <td><?php echo $product['price'] ?></td>
                            <td><?php echo $product['description'] ?></td>
                            <td><?php
                                $categoryDetail = $category->category_readById($product['category_id']);
                                $categoryDetail = mysqli_fetch_object($categoryDetail);
                                echo $categoryDetail->name;
                                ?></td>
                            <td><?php echo $product['status'] == 0 ? 'Inactive' : 'Active' ?></td>
                            <td style="display: flex; align-items: center">
                                <a href="product_edit.php?id=<?php echo $product['id'] ?>" class="btn btn-warning">Edit</a>&nbsp;
                                <form method="post">
                                    <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                                    <button onclick="return confirm('Do you want delete ?')" type="submit" name="deleteProduct" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->
<div id="footer-sec">
    &copy; 2014 YourCompany | Design By : <a href="http://www.binarytheme.com/" target="_blank">BinaryTheme.com</a>
</div>
<!-- /. FOOTER  -->
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="assets/js/jquery.metisMenu.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="assets/js/custom.js"></script>


</body>
</html>
