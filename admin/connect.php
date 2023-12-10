<?php
$server = "localhost";

$user = "root";
$pass = "";
$database = "webbanhang";

// $user = "id19693167_admin";
// $pass = "Test@123";
// $database = "id19693167_webbanhang";

$conn = mysqli_connect($server, $user, $pass, $database);
mysqli_query($conn, 'set names"utf8"');