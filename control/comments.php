<?php

include '../config/connect.php';

class Comment {
    public function create($name, $description) {
        global $conn;
        $insert="insert into comments(name, description) values ('$name', '$description')";
        return mysqli_query ($conn,$insert);
    }
    public function read() {
        global $conn;
        $select="select* from comments";
        return mysqli_query ($conn,$select);
    }
    public function update($id, $name, $description) {
        global $conn;
        $update="update comments set name='$name', description='$description' where id='$id'";
        return mysqli_query ($conn,$update);
    }
    public function delete($id) {
        global $conn;
        $delete="delete from comments where id='$id'";
        return mysqli_query ($conn,$delete);
    }
    public function readById($id) {
        global $conn;
        $select="select* from comments where id='$id'";
        return mysqli_query ($conn,$select);
    }
}