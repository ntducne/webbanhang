<?php
include "control.php";
session_start();

if (!isset($_SESSION['authUser'])) {
    header('Location: /admin/login.php');
}
$user = $_SESSION['authUser'];
$username = $user['username'];
$name = $user['name'];
$image = $user['image'];
$role = $user['role'];

$user = new Data();
$users = $user->user_read();


if (isset($_POST['deleteUser'])) {
    $id = $_POST['id'];
    // delete image
    $select = mysqli_fetch_array($user->user_readById($id));
    $image = $select['image'];
    unlink('../uploads/' . $image);
    $delete = $user->user_delete($id);
    header('Location: user.php');
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
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!--CUSTOM BASIC STYLES-->
    <link href="assets/css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
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
                <a class="navbar-brand" href="./">CQ Store</a>
            </div>

            <div class="header-right">

                <a href="logout.php" class="btn btn-danger" title="Logout"><i class="fa fa-exclamation-circle fa-2x"></i></a>


            </div>
        </nav>
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <?php
                    $user = $_SESSION['authUser'];

                    $username = $user['username'];
                    $name = $user['name'];
                    $image = $user['image'];

                    ?>

                    <li>
                        <div class="user-img-div">
                            <img src="../uploads/<?php echo $image ?>" class="img-thumbnail" />
                            <div class="inner-text"><?php echo $name ?><br /></div>
                        </div>
                    </li>


                    <li><a href="./">Dashboard</a></li>
                    <li><a href="./category.php">Category </a></li>
                    <li><a href="./product.php">Product </a></li>
                    <li><a class="active-menu" href="./user.php">User </a></li>
                    <li><a href="./order.php">Order </a></li>


                </ul>
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">User</h1>
                        <h1 class="page-subhead-line"><a href="user_create.php" class="btn btn-success">Create</a></h1>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>UserName</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $value) : ?>
                                <tr>
                                    <td><?php echo $value['id'] ?></td>
                                    <td><img src="..../uploads/<?php echo $value['image'] ?>" width="100px" height="100px" />
                                    </td>
                                    <td><?php echo $value['name'] ?></td>
                                    <td><?php echo $value['username'] ?></td>
                                    <td><?php echo $value['email'] ?></td>
                                    <td>
                                        <?php echo $value['role'] == 0 ? 'Admin' : '' ?>
                                        <?php echo $value['role'] == 1 ? 'Staff' : '' ?>
                                        <?php echo $value['role'] == 2 ? 'Client' : '' ?>
                                    </td>
                                    <?php if ($role == 0) { ?>
                                        <td style="display: flex; align-items: center">
                                            <a href="user_edit.php?id=<?php echo $value['id'] ?>" class="btn btn-warning">Edit</a>&nbsp;
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?php echo $value['id'] ?>">
                                                <button onclick="return confirm('Do you want delete ?')" type="submit" name="deleteUser" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    <?php } ?>
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