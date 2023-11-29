<?php

include '../config/connect.php';

class Category {
    public function create($name, $description) {
        global $conn;
        $insert="insert into categories(name, description) values ('$name', '$description')";
        return mysqli_query ($conn,$insert);
    }
    public function read() {
        global $conn;
        $select="select* from categories";
        return mysqli_query ($conn,$select);
    }
    public function update($id, $name, $description) {
        global $conn;
        $update="update categories set name='$name', description='$description' where id='$id'";
        return mysqli_query ($conn,$update);
    }
    public function delete($id) {
        global $conn;
        $delete="delete from categories where id='$id'";
        return mysqli_query ($conn,$delete);
    }
    public function readById($id) {
        global $conn;
        $select="select* from categories where id='$id'";
        return mysqli_query ($conn,$select);
    }
}