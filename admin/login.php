<?php
    include "control.php";
    session_start();
    if(isset($_SESSION['authUser'])){
        header('Location: index.php');
    }
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['login'];
        $auth = new Data();
        $login = mysqli_fetch_array($auth->login($username,$password));
        if($login){
            Session::set('authUser',[
                'id' => $login['id'],
                'image' => $login['image'],
                'name' => $login['name'],
                'email' => $login['email'],
                'phone' => $login['phone'],
                'address' => $login['address'],
                'username' => $login['username'],
                'role' => $login['role'],
            ]);
            header('location: index.php');
        }
        else{
            echo "<script>alert('Username or password is incorrect')</script>";
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="./assets/css/login.css">
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
<div class="wrapper fadeInDown">
    <div id="formContent">
        <form method="post">
            <input type="text" id="login" class="fadeIn second mt-4" name="username" placeholder="username" required>
            <input type="password" id="password" class="fadeIn third" name="login" placeholder="password" required>
            <input type="submit"  class="fadeIn fourth" value="Log In">
        </form>
    </div>
</div>
</body>
</html>