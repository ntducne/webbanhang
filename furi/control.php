<?php

include 'connect.php';

class Data
{
    public function select_product()
    {
        global $conn;
        $select = "select * from products";
        $run = mysqli_query($conn, $select);
        return $run;
    }

    public function read_product_by_id($id)
    {
        global $conn;
        $select = "select * from products where id='$id'";
        return mysqli_query($conn, $select);
    }

    public function login($user, $pass)
    {
        global $conn;
        $select = "select* from users where username='$user' and password='$pass'";
        $run = mysqli_query($conn, $select);
        return $run;
    }

    public function insert_order($user_id, $order_code, $customer_name, $customer_addresss, $customer_email, $customer_phone, $order_note, $payment_method, $order_status, $order_date, $order_total)
    {
        global $conn;
        $insert = "insert into orders(user_id, order_code, customer_name, customer_address, customer_email, customer_phone, note, payment_method, status, order_date, total) values ('$user_id','$order_code', '$customer_name', '$customer_addresss', '$customer_email', '$customer_phone', '$order_note', '$payment_method', '$order_status', '$order_date', '$order_total')";
        return mysqli_query($conn, $insert);
    }

    public function insert_order_2( $order_code, $customer_name, $customer_addresss, $customer_email, $customer_phone, $order_note, $payment_method, $order_status, $order_date, $order_total)
    {
        global $conn;
        $insert = "insert into orders(order_code, customer_name, customer_address, customer_email, customer_phone, note, payment_method, status, order_date, total) values ('$order_code', '$customer_name', '$customer_addresss', '$customer_email', '$customer_phone', '$order_note', '$payment_method', '$order_status', '$order_date', '$order_total')";
        return mysqli_query($conn, $insert);
    }

    public function insert_order_detail($order_id, $name, $quantity, $price)
    {
        global $conn;
        $insert = "insert into order_details(order_id, name, quantity, price) values ('$order_id', '$name', '$quantity', '$price')";
        return mysqli_query($conn, $insert);
    }

    public function readByOrderCode($orderCode)
    {
        global $conn;
        $select = "select* from orders where order_code='$orderCode'";
        return mysqli_query($conn, $select);
    }

    public function getOrderDetail($order_id)
    {
        global $conn;
        $select = "select* from order_details where order_id='$order_id'";
        return mysqli_query($conn, $select);
    }

    public function read_order_by_user($user_id) {
        global $conn;
        $select="select* from orders where user_id='$user_id'";
        return mysqli_query ($conn,$select);
    }
}
