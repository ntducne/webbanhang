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



    $id = $_GET['id'];
    if(!isset($id)){
        header('Location: ./index.php');
    }
    $productDetail = $product->readById($id);
    $productDetail = mysqli_fetch_object($productDetail);


    if (isset($_POST['updateProduct'])) {
        $id = $_GET['id'];

        $name = $_POST['name'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];
        $description = $_POST['description'];
        $image = $_FILES['image']['name'];
        if($_FILES['image']['name'] == ''){
            $image = $productDetail->image;
        } else {
            $image = $_FILES['image']['name'];
            move_uploaded_file($_FILES["image"]["tmp_name"], "../../uploads/".$_FILES["image"]["name"]);
        }
        $status = $_POST['status'];
        $product->update($id, $name, $description, $price, $image, $category_id, $status);
        header('Location: ./index.php');
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Responsive Bootstrap Advance Admin Template</title>

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
            <a class="navbar-brand" href="index.html">COMPANY NAME</a>
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

            </ul>
        </div>

    </nav>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper">
        <div id="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">Product Edit</h1>
                    <h1 class="page-subhead-line"><a href="./index.php" class="btn btn-danger">Cancel</a></h1>
                </div>
            </div>
            <div class="table-responsive">
                <form method="post" enctype="multipart/form-data">
                    <label for="">Name product</label>
                    <input type="text" name="name" class="form-control" placeholder="Name product" value="<?php echo $productDetail->name ?>">
                    <br>
                    <label for="">Price</label>
                    <input type="text" name="price" class="form-control" placeholder="Price" value="<?php echo $productDetail->price ?>">
                    <br>

                    <label for="">Category</label>
                    <select name="category_id" class="form-control">
                        <?php
                            $categoryList = $category->read();
                            while ($row = mysqli_fetch_object($categoryList)) {
                                if ($row->id == $productDetail->category_id) {
                                    echo "<option value='$row->id' selected>$row->name</option>";
                                } else {
                                    echo "<option value='$row->id'>$row->name</option>";
                                }
                            }
                        ?>
                    </select>
                    <br>

                    <label for="">Description</label>
                    <textarea name="description" class="form-control" placeholder="Description"><?php echo $productDetail->description ?></textarea>
                    <br>

                    <label for="">Image</label>
                    <input type="file" name="image" class="form-control" placeholder="Image">
                    <br>

                    <label for="">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?php echo $productDetail->status == 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?php echo $productDetail->status == 0 ? 'selected' : '' ?>>Deactive</option>
                    </select>
                    <br>
                    <button type="submit" name="updateProduct" class="btn btn-success">Update</button>
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
