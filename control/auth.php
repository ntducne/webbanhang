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
            '$name', '$username', '$password', '$email', '$phone', 2, 'https://res.cloudinary.com/dteefej4w/image/upload/v1681474078/users/585e4bf3cb11b227491c339a_gtyczj.png'
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