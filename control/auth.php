<?php

include '../config/connect.php';

class Auth {
    public function login($username, $password) {
        global $conn;
        $select="select* from user where username='$username' and password='$password'";
        return mysqli_query ($conn,$select);
    }
    public function register($username, $password, $email, $fullname, $address, $phone) {
        global $conn;
        $insert="insert into user(username, password, email, fullname, address, phone) values ('$username', '$password', '$email', '$fullname', '$address', '$phone')";
        return mysqli_query ($conn,$insert);
    }
    public function checkUsername($username) {
        global $conn;
        $select="select* from user where username='$username'";
        return mysqli_query ($conn,$select);
    }
    public function forgotPassword($email) {
        global $conn;
        $select="select* from user where email='$email'";
        return mysqli_query ($conn,$select);
    }
    public function changePassword($username, $password) {
        global $conn;
        $update="update user set password='$password' where username='$username'";
        return mysqli_query ($conn,$update);
    }
}