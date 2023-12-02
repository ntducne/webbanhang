<?php
    include "../../config/session.php";
    Session::checkSession();
    $user = Session::get('authUser');
    $username = $user['username'];
    $name = $user['name'];
    $image = $user['image'];
    include '../../config/connect.php';
    include '../../config/formatMoney.php';
    include '../../config/renderStatus.php';
    include '../../control/comments.php';
    include '../../control/product.php';
    $product = new Product();
    $comment = new Comment();
    $comments = $comment->read();
    if (isset($_POST['block'])) {
        $comment->update($_POST['review_id'], 0);
        header('Location: /admin/review/');
    }
    if (isset($_POST['open'])) {
        $comment->update($_POST['review_id'], 1);
        header('Location: /admin/review/');
    }
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CQ Store - Admin</title>
<link rel="shortcut icon" href="/favicon.png">

    <!-- BOOTSTRAP STYLES-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <!--CUSTOM BASIC STYLES-->
    <link href="../assets/css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="../assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
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
                        <img src="<?php echo $image ?>" class="img-thumbnail" />
                        <div class="inner-text"><?php echo $name ?><br /></div>
                    </div>

                </li>


                <li><a href="/admin/">Dashboard</a></li>
                <li><a href="/admin/category/">Category </a></li>
                <li><a href="/admin/product/">Product </a></li>
                <li><a href="/admin/user/">User </a></li>
                <li><a href="/admin/order/">Order </a></li>
                <li><a class="active-menu" href="/admin/review/">Review </a></li>

            </ul>
        </div>

    </nav>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper">
        <div id="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">Order</h1>
                    <!-- <h1 class="page-subhead-line"><a href="./create.php" class="btn btn-success">Create</a></h1> -->
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Time</th>
                            <th>Customer Name</th>
                            <th>Star</th>
                            <th>Review</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comments as $item): ?>
                            <tr>
                                <td><?php echo $item['id'] ?></td>
                                <td>
                                    <a style="color: #000" target="_blank" href="/detail.php?id=<?php echo $item['product_id'] ?>">
                                        <?php
                                            $productDetail = $product->readById($item['product_id']);
                                            $productDetail = mysqli_fetch_object($productDetail);
                                            echo $productDetail->name;
                                        ?>
                                    </a>
                                </td>
                                <td><?php echo $item['time'] ?></td>
                                <td><?php echo $item['customer_name'] ?></td>
                                <td><?php echo $item['star'] ?></td>
                                <td><?php echo $item['review'] ?></td>
                                <td><?php echo $item['status'] == 0 ? 'Block' : 'Open' ?></td>
                                <td>
                                    <form method="post">
                                        <input type="hidden" name="review_id" value="<?php echo $item['id'] ?>">
                                        <?php if ($item['status'] == 1): ?>
                                            <input type="submit" name="block" value="Block" class="btn btn-danger">
                                        <?php else: ?>
                                            <input type="submit" name="open" value="Open" class="btn btn-success">
                                        <?php endif; ?>
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
<script src="../assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="../assets/js/bootstrap.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="../assets/js/jquery.metisMenu.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="../assets/js/custom.js"></script>


</body>
</html>
