<?php

class Auth {
    public function login($username, $password) {
        global $conn;
        $select="select* from users where username='$username' and password='$password'";
        return mysqli_query ($conn,$select);
    }
}