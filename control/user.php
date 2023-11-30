<?php

class User {
    public function create($name, $username, $password, $email, $phone, $image, $role, $status) {
        global $conn;
        $insert = "INSERT INTO users (name, username, password, email, phone, image, role, status) VALUES ('$name', '$username', '$password', '$email', '$phone', '$image', '$role', '$status')";
        return mysqli_query($conn, $insert);
    }
    public function read() {
        global $conn;
        $select = "SELECT * FROM users WHERE id != '1'";
        return mysqli_query($conn, $select);
    }

    public function update($id, $name, $username, $password, $email, $phone, $image, $role, $status) {
        global $conn;
        $update = "UPDATE users SET name='$name', username='$username', password='$password', email='$email', phone='$phone', image='$image', role='$role', status='$status' WHERE id='$id'";
        return mysqli_query($conn, $update);
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