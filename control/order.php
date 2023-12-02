<?php

class Order {
    public function create($user_id, $order_code, $customer_name, $customer_addresss, $customer_email, $customer_phone, $order_note, $payment_method, $order_status, $order_date, $order_total) {
        global $conn;
        $insert="insert into orders(user_id, order_code, customer_name, customer_address, customer_email, customer_phone, note, payment_method, status, order_date, total) values ('$user_id','$order_code', '$customer_name', '$customer_addresss', '$customer_email', '$customer_phone', '$order_note', '$payment_method', '$order_status', '$order_date', '$order_total')";
        return mysqli_query ($conn,$insert);
    }

    public function read() {
        global $conn;
        $select="select* from orders";
        return mysqli_query ($conn,$select);
    }

    public function update($order_code, $status) {
        global $conn;
        $update="update orders set status='$status' where order_code='$order_code'";
        return mysqli_query ($conn,$update);
    }

    public function delete($id) {
        global $conn;
        $delete="delete from orders where id='$id'";
        return mysqli_query ($conn,$delete);
    }

    public function readByIdUser($user_id) {
        global $conn;
        $select="select* from orders where user_id='$user_id'";
        return mysqli_query ($conn,$select);
    }

    public function readByOrderCode($orderCode) {
        global $conn;
        $select="select* from orders where order_code='$orderCode'";
        return mysqli_query ($conn,$select);
    }

    public function addOrderDetail($order_id, $product_id, $name, $quantity, $price) {
        global $conn;
        $insert="insert into order_details(order_id, product_id, name, quantity, price) values ('$order_id', '$product_id', '$name', '$quantity', '$price')";
        return mysqli_query ($conn,$insert);
    }

    public function getOrderDetail($order_id) {
        global $conn;
        $select="select* from order_details where order_id='$order_id'";
        return mysqli_query ($conn,$select);
    }
}