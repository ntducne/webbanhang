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
    include '../../control/order.php';

    $order_code = $_GET['order_code'];
    $orderModel = new Order();
    $orders = $orderModel->readByOrderCode($order_code);
    $order = $orders->fetch_assoc();
    $orderDetail = $orderModel->getOrderDetail($order['id']);
    if(isset($_POST['updateStatusOrder'])) {
        $status = $_POST['updateStatusOrder'];
        $orderModel->update($order_code, $status);
        header("Location: ./detail.php?order_code=$order_code");
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
                    <li><a class="active-menu" href="/admin/order/">Order </a></li>
                    <li><a href="/admin/review/">Review </a></li>

                </ul>
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
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
                                            Total: <?php echo formatMoneyVN($total + 20000) ?> <br> <?php echo  renderStatusOrder($order['status']) ?></p>
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
                            <?php if($order['status'] != 5) { ?>
                                <form method="post">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Change Status</label>
                                        <select class="form-control" name="updateStatusOrder">
                                            <option value="0" <?php echo $order['status'] == 0 ? 'selected' : '' ?> >Pending</option>
                                            <option value="1" <?php echo $order['status'] == 1 ? 'selected' : '' ?>>Confirmed</option>
                                            <option value="2" <?php echo $order['status'] == 2 ? 'selected' : '' ?>>Delivering</option>
                                            <option value="3" <?php echo $order['status'] == 3 ? 'selected' : '' ?>>Delivered</option>
                                            <option value="4" <?php echo $order['status'] == 4 ? 'selected' : '' ?>>Cancelled</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                                
                            <?php } else { ?>
                                
                                <?php echo renderStatusOrder($order['status']) ?>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order Code</th>
                        <th>Order Date</th>
                        <th>Customer Name</th>
                        <th>Customer Phone</th>
                        <th>Customer Address</th>
                        <th>Note</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $item) : ?>
                        <tr>
                            <td><?php echo $item['id'] ?></td>
                            <td><?php echo $item['order_code'] ?></td>
                            <td><?php echo $item['order_date'] ?></td>
                            <td><?php echo $item['customer_name'] ?></td>
                            <td><?php echo $item['customer_phone'] ?></td>
                            <td><?php echo $item['customer_address'] ?></td>
                            <td><?php echo $item['note'] ?></td>
                            <td><?php echo formatMoneyVN($item['total']) ?></td>
                            <td><?php echo renderStatusOrder($item['status']) ?></td>
                            <td>
                                <a href="./detail.php?id=<?php echo $item['id'] ?>" class="btn btn-secondary">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div> -->
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