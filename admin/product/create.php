<?php
    include "../../config/session.php";
    Session::checkSession();
$user = Session::get('authUser');
$username = $user['username'];
$name = $user['name'];
$image = $user['image'];
    include '../../config/connect.php';
    include '../../control/product.php';
    include '../../control/category.php';
    $product = new Product();
    $category = new Category();
    $products = $product->read();
    if (isset($_POST['createProduct'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];
        $description = $_POST['description'];
        $image = time().$_FILES['image']['name'];
        move_uploaded_file($_FILES["image"]["tmp_name"], "../../uploads/".$image);
        $status = $_POST['status'];
        $product->create($name, $description, $price, $image, $category_id, $status);
        header('Location: ./index.php');
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
    <link href="../assets/css/bootstrap.css" rel="stylesheet"/>
    <!-- FONTAWESOME STYLES-->
    <link href="../assets/css/font-awesome.css" rel="stylesheet"/>
    <!--CUSTOM BASIC STYLES-->
    <link href="../assets/css/basic.css" rel="stylesheet"/>
    <!--CUSTOM MAIN STYLES-->
    <link href="../assets/css/custom.css" rel="stylesheet"/>
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
                        <img src="<?php echo $image ?>" class="img-thumbnail" />
                        <div class="inner-text"><?php echo $name ?><br /></div>
                    </div>

                </li>


                <li><a href="/admin/">Dashboard</a></li>
                <li><a href="/admin/category/">Category </a></li>
                <li><a class="active-menu" href="/admin/product/">Product </a></li>
                <li><a href="/admin/user/">User </a></li>
                <li><a href="/admin/order/">Order </a></li>
<li><a href="/admin/review/">Review </a></li>

            </ul>
        </div>

    </nav>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper">
        <div id="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">Product Create</h1>
                    <h1 class="page-subhead-line"><a href="./index.php" class="btn btn-danger">Cancel</a></h1>
                </div>
            </div>
            <div class="table-responsive">
                <form method="post" enctype="multipart/form-data">
                    <label for="">Name product</label>
                    <input type="text" name="name" class="form-control" placeholder="Name product">
                    <br>
                    <label for="">Price</label>
                    <input type="text" name="price" class="form-control" placeholder="Price">
                    <br>

                    <label for="">Category</label>
                    <select name="category_id" class="form-control">
                        <?php
                            $categories = $category->read();
                            foreach ($categories as $category) {
                                echo "<option value='" . $category['id'] . "'>" . $category['name'] . "</option>";
                            }
                        ?>
                    </select>
                    <br>

                    <label for="">Description</label>
                    <textarea name="description" class="form-control" placeholder="Description"></textarea>
                    <br>

                    <label for="">Image</label>
                        <input type="file" name="image" class="form-control" placeholder="Image">
                    <br>

                    <label for="">Status</label>
                    <select name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Deactive</option>
                    </select>
                    <br>
                    <button type="submit" name="createProduct" class="btn btn-success">Create</button>
                </form>
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
