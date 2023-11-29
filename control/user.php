<?php

include '../config/connect.php';

class User {
    public function create($name, $email, $password, $role) {
        global $conn;
        $insert="insert into users(name, email, password, role) values ('$name', '$email', '$password', '$role')";
        return mysqli_query ($conn,$insert);
    }
    public function read() {
        global $conn;
        $select="select* from users";
        return mysqli_query ($conn,$select);
    }
    public function update($id, $name, $email, $password, $role) {
        global $conn;
        $update="update users set name='$name', email='$email', password='$password', role='$role' where id='$id'";
        return mysqli_query ($conn,$update);
    }
    public function delete($id) {
        global $conn;
        $delete="delete from users where id='$id'";
        return mysqli_query ($conn,$delete);
    }
    public function readById($id) {
        global $conn;
        $select="select* from users where id='$id'";
        return mysqli_query ($conn,$select);
    }
}