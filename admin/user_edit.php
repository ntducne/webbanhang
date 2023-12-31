<?php
    include "control.php";
    session_start();

if(!isset($_SESSION['authUser'])){
        header('Location: /admin/login.php');
    }
    $user = $_SESSION['authUser'];
    $username = $user['username'];
    $name = $user['name'];
    $image = $user['image'];
    $id = $_GET['id'];
    if(!isset($id)){
        header('Location: user.php');
    }
    $user = new Data();
    $userDetail = $user->user_readById($id);
    $userDetail = mysqli_fetch_object($userDetail);
    if (isset($_POST['updateUser'])) {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $role = $_POST['role'];
        $status = $_POST['status'];
        $image = time().$_FILES['image']['name'];
        if($_FILES['image']['name'] == ''){
            $image = $userDetail->image;
        } else {
            // delete image
            unlink('../uploads/'.$userDetail->image);
            $image = $_FILES['image']['name'];
            move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/".$image);
        }
        $create = $user->user_update($id, $name, $username, $password, $email, $phone, $image, $role, $status);
        if ($create) {
            header('Location: user.php');
        }
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
            <a class="navbar-brand" href="./">CQ Store</a>
        </div>

        <div class="header-right">

            <a href="./logout.php" class="btn btn-danger" title="Logout"><i class="fa fa-exclamation-circle fa-2x"></i></a>



        </div>
    </nav>
    <!-- /. NAV TOP  -->
    <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">
                <li>
                    <div class="user-img-div">
                        <img src="../uploads/<?php echo $image ?>" class="img-thumbnail" />
                        <div class="inner-text"><?php echo $name ?><br /></div>
                    </div>

                </li>


                <li><a href="./">Dashboard</a></li>
                <li><a href="./category.php">Category </a></li>
                <li><a class="active-menu" href="./product.php">Product </a></li>
                <li><a href="./user.php">User </a></li>
                <li><a href="./order.php">Order </a></li>


            </ul>
        </div>

    </nav>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper">
        <div id="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">User Edit</h1>
                    <h1 class="page-subhead-line"><a href="user.php" class="btn btn-danger">Cancel</a></h1>
                </div>
            </div>
            <div class="table-responsive">
                <form method="post" enctype="multipart/form-data">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo $userDetail->name ?>">
                    <br>
                    <label for="">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $userDetail->username ?>">
                    <br>
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $userDetail->email ?>">
                    <br>
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo $userDetail->password ?>">
                    <br>
                    <label for="">Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="Phone" value="<?php echo $userDetail->phone ?>">
                    <br>
                    <label for="">Image</label>
                    <input type="file" name="image" class="form-control" placeholder="Image">
                    <br>
                    <label for="">Role</label><br>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary <?php if($userDetail->role == 1) echo "active" ?>">
                            <input type="radio" name="role" value="1" <?php if($userDetail->role == 1) echo "checked" ?>> Staff
                        </label>
                        <label class="btn btn-primary <?php if($userDetail->role == 2) echo "active" ?>">
                            <input type="radio" name="role" value="2" <?php if($userDetail->role == 2) echo "checked" ?>> Client
                        </label>
                    </div>
                    <br><br>
                    <label for="">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?php if($userDetail->status == 1) echo "selected" ?>>Active</option>
                        <option value="0" <?php if($userDetail->status == 0) echo "selected" ?>>Deactive</option>
                    </select>
                    <br>
                    <button type="submit" name="updateUser" class="btn btn-success">Update</button>
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
<script src="assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="assets/js/jquery.metisMenu.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="assets/js/custom.js"></script>


</body>
</html>
