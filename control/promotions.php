<?php

include '../config/connect.php';

class Promotion {
    public function create($name, $discount, $start_date, $end_date) {
        global $conn;
        $insert="insert into promotions(name, discount, start_date, end_date) values ('$name', '$discount', '$start_date', '$end_date')";
        return mysqli_query ($conn,$insert);
    }
    public function read() {
        global $conn;
        $select="select* from promotions";
        return mysqli_query ($conn,$select);
    }
    public function update($id, $name, $discount, $start_date, $end_date) {
        global $conn;
        $update="update promotions set name='$name', discount='$discount', start_date='$start_date', end_date='$end_date' where id='$id'";
        return mysqli_query ($conn,$update);
    }
    public function delete($id) {
        global $conn;
        $delete="delete from promotions where id='$id'";
        return mysqli_query ($conn,$delete);
    }
    public function readById($id) {
        global $conn;
        $select="select* from promotions where id='$id'";
        return mysqli_query ($conn,$select);
    }
}