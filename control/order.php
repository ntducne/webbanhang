<?php

class Order {
    public function create($order_code, $customer_name, $customer_addresss, $customer_email, $customer_phone, $order_note, $payment_method, $order_status, $order_date, $order_total) {
        global $conn;
        $insert="insert into orders(order_code, customer_name, customer_address, customer_email, customer_phone, note, payment_method, status, order_date, total) values ('$order_code', '$customer_name', '$customer_addresss', '$customer_email', '$customer_phone', '$order_note', '$payment_method', '$order_status', '$order_date', '$order_total')";
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

    public function getOrderWithOrderDetail(){
        global $conn;
        $select="select orders.*, order_details.quantity, order_details.price, products.name as product_name from orders join order_details on orders.id=order_details.order_id join products on order_details.product_id=products.id";
        return mysqli_query ($conn,$select);
    }
}