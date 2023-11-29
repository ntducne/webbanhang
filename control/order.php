<?php

include '../config/connect.php';

class Order {
    public function create($user_id, $total, $status) {
        global $conn;
        $insert="insert into orders(user_id, total, status) values ('$user_id', '$total', '$status')";
        return mysqli_query ($conn,$insert);
    }
    public function read() {
        global $conn;
        $select="select* from orders";
        return mysqli_query ($conn,$select);
    }
    public function update($id, $user_id, $total, $status) {
        global $conn;
        $update="update orders set user_id='$user_id', total='$total', status='$status' where id='$id'";
        return mysqli_query ($conn,$update);
    }
    public function delete($id) {
        global $conn;
        $delete="delete from orders where id='$id'";
        return mysqli_query ($conn,$delete);
    }
    public function readById($id) {
        global $conn;
        $select="select* from orders where id='$id'";
        return mysqli_query ($conn,$select);
    }

    public function addOrderDetail($order_id, $product_id, $quantity, $price) {
        global $conn;
        $insert="insert into order_details(order_id, product_id, quantity, price) values ('$order_id', '$product_id', '$quantity', '$price')";
        return mysqli_query ($conn,$insert);
    }

    public function getOrderWithOrderDetail(){
        global $conn;
        $select="select orders.*, order_details.quantity, order_details.price, products.name as product_name from orders join order_details on orders.id=order_details.order_id join products on order_details.product_id=products.id";
        return mysqli_query ($conn,$select);
    }
}