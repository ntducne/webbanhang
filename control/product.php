<?php

include '../config/connect.php';

class Product {
    public function create($name, $description, $price, $image, $category_id) {
        global $conn;
        $insert="insert into products(name, description, price, image, category_id) values ('$name', '$description', '$price', '$image', '$category_id')";
        return mysqli_query ($conn,$insert);
    }

    public function getProductWithCategory() {
        global $conn;
        $select="select products.*, categories.name as category_name from products join categories on products.category_id=categories.id";
        return mysqli_query ($conn,$select);
    }

    public function read() {
        global $conn;
        $select="select* from products";
        return mysqli_query ($conn,$select);
    }
    public function update($id, $name, $description, $price, $image, $category_id) {
        global $conn;
        $update="update products set name='$name', description='$description', price='$price', image='$image', category_id='$category_id' where id='$id'";
        return mysqli_query ($conn,$update);
    }
    public function delete($id) {
        global $conn;
        $delete="delete from products where id='$id'";
        return mysqli_query ($conn,$delete);
    }
    public function readById($id) {
        global $conn;
        $select="select* from products where id='$id'";
        return mysqli_query ($conn,$select);
    }
}