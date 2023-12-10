<?php 
include 'connect.php';
class Data {
    public function login($user, $pass)
    {
        global $conn;
        $select = "select* from users where username='$user' and password='$pass'";
        $run = mysqli_query($conn, $select);
        return $run;
    }
    
    public function category_create($name)
    {
        global $conn;
        $insert = "insert into categories(name) values ('$name')";
        return mysqli_query($conn, $insert);
    }

    public function category_read()
    {
        global $conn;
        $select = "select* from categories";
        return mysqli_query($conn, $select);
    }

    public function category_update($id, $name)
    {
        global $conn;
        $update = "UPDATE categories SET name='$name' WHERE id='$id'";
        return mysqli_query($conn, $update);
    }

    public function category_delete($id)
    {
        global $conn;
        $delete = "delete from categories where id='$id'";
        return mysqli_query($conn, $delete);
    }

    public function category_readById($id)
    {
        global $conn;
        $select = "select* from categories where id='$id'";
        return mysqli_query($conn, $select);
    }


    public function product_create($name, $description, $price, $image, $category_id, $status) {
        global $conn;
        $insert="insert into products(name, description, price, image, category_id, status) values ('$name', '$description', '$price', '$image', '$category_id', '$status')";
        return mysqli_query ($conn,$insert);
    }

    public function product_getProductWithCategory() {
        global $conn;
        $select="select products.*, categories.name as category_name from products join categories on products.category_id=categories.id";
        return mysqli_query ($conn,$select);
    }

    public function product_read() {
        global $conn;
        $select="select* from products";
        return mysqli_query ($conn,$select);
    }

    public function product_update($id, $name, $description, $price, $image, $category_id, $status) {
        global $conn;
        $update="update products set name='$name', description='$description', price='$price', image='$image', category_id='$category_id', status='$status' where id='$id'";
        return mysqli_query ($conn,$update);
    }

    public function product_delete($id) {
        global $conn;
        $delete="delete from products where id='$id'";
        return mysqli_query ($conn,$delete);
    }

    public function product_readById($id) {
        global $conn;
        $select="select* from products where id='$id'";
        return mysqli_query ($conn,$select);
    }

    public function user_create($name, $username, $password, $email, $phone, $image, $role, $status) {
        global $conn;
        $insert = "INSERT INTO users (name, username, password, email, phone, image, role, status) VALUES ('$name', '$username', '$password', '$email', '$phone', '$image', '$role', '$status')";
        return mysqli_query($conn, $insert);
    }

    public function user_read() {
        global $conn;
        $select = "SELECT * FROM users WHERE id != '1'";
        return mysqli_query($conn, $select);
    }

    public function user_update($id, $name, $username, $password, $email, $phone, $image, $role, $status) {
        global $conn;
        $update = "UPDATE users SET name='$name', username='$username', password='$password', email='$email', phone='$phone', image='$image', role='$role', status='$status' WHERE id='$id'";
        return mysqli_query($conn, $update);
    }

    public function user_delete($id) {
        global $conn;
        $delete="delete from users where id='$id'";
        return mysqli_query ($conn,$delete);
    }

    public function user_readById($id) {
        global $conn;
        $select="select* from users where id='$id'";
        return mysqli_query ($conn,$select);
    }

    public function order_create($user_id, $order_code, $customer_name, $customer_addresss, $customer_email, $customer_phone, $order_note, $payment_method, $order_status, $order_date, $order_total) {
        global $conn;
        $insert="insert into orders(user_id, order_code, customer_name, customer_address, customer_email, customer_phone, note, payment_method, status, order_date, total) values ('$user_id','$order_code', '$customer_name', '$customer_addresss', '$customer_email', '$customer_phone', '$order_note', '$payment_method', '$order_status', '$order_date', '$order_total')";
        return mysqli_query ($conn,$insert);
    }

    public function order_read() {
        global $conn;
        $select="select* from orders";
        return mysqli_query ($conn,$select);
    }

    public function order_update($order_code, $status) {
        global $conn;
        $update="update orders set status='$status' where order_code='$order_code'";
        return mysqli_query ($conn,$update);
    }

    public function order_delete($id) {
        global $conn;
        $delete="delete from orders where id='$id'";
        return mysqli_query ($conn,$delete);
    }

    public function order_readByIdUser($user_id) {
        global $conn;
        $select="select* from orders where user_id='$user_id'";
        return mysqli_query ($conn,$select);
    }

    public function order_readByOrderCode($orderCode) {
        global $conn;
        $select="select* from orders where order_code='$orderCode'";
        return mysqli_query ($conn,$select);
    }

    public function order_addOrderDetail($order_id, $name, $quantity, $price) {
        global $conn;
        $insert="insert into order_details(order_id, name, quantity, price) values ('$order_id', '$name', '$quantity', '$price')";
        return mysqli_query ($conn,$insert);
    }

    public function order_getOrderDetail($order_id) {
        global $conn;
        $select="select* from order_details where order_id='$order_id'";
        return mysqli_query ($conn,$select);
    }
}