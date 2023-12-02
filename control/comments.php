<?php

class Comment {
    public function create($customer_name, $customer_image, $star, $product_id, $review, $time) {
        global $conn;
        $sql = "INSERT INTO comments (customer_name, customer_image, star, product_id, review, time, status) VALUES ('$customer_name', '$customer_image', '$star', '$product_id', '$review', '$time', 1)";
        return mysqli_query($conn, $sql);
    }
    public function read() {
        global $conn;
        $sql = "SELECT * FROM comments";
        return mysqli_query($conn, $sql);
    }
    public function readByProductId($product_id) {
        global $conn;
        $sql = "SELECT * FROM comments WHERE product_id='$product_id'";
        return mysqli_query($conn, $sql);
    }
    public function update($review_id, $status) {
        global $conn;
        $sql = "UPDATE comments SET status='$status' WHERE id='$review_id'";
        return mysqli_query($conn, $sql);
    }
}