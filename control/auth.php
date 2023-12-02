<?php

class Auth {
    public function login($username, $password) {
        global $conn;
        $select="select* from users where username='$username' and password='$password'";
        return mysqli_query ($conn,$select);
    }
    public function register($name, $username, $email, $phone, $password) {
        global $conn;
        $insert="insert into users (name, username, password, email, phone, role, image ) values (
            '$name', '$username', '$password', '$email', '$phone', 2, 'user.png'
        )";
        return mysqli_query ($conn,$insert);
    }
    public function checkUsername($username) {
        global $conn;
        $select="select* from users where username='$username'";
        return mysqli_query ($conn,$select);
    }
    public function changePassword($username, $password) {
        global $conn;
        $update="update users set password='$password' where username='$username'";
        return mysqli_query ($conn,$update);
    }
}