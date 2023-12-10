<?php

//include '../config/connect.php';

class Category
{
    public function create($name)
    {
        global $conn;
        $insert = "insert into categories(name) values ('$name')";
        return mysqli_query($conn, $insert);
    }

    public function read()
    {
        global $conn;
        $select = "select* from categories";
        return mysqli_query($conn, $select);
    }

    public function update($id, $name)
    {
        global $conn;
        $update = "UPDATE categories SET name='$name' WHERE id='$id'";
        return mysqli_query($conn, $update);
    }

    public function delete($id)
    {
        global $conn;
        $delete = "delete from categories where id='$id'";
        return mysqli_query($conn, $delete);
    }

    public function readById($id)
    {
        global $conn;
        $select = "select* from categories where id='$id'";
        return mysqli_query($conn, $select);
    }
}