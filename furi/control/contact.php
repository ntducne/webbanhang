<?php

class Contact {
    public function read(){
        global $conn;
        $select="select* from contact";
        return mysqli_query ($conn,$select);
    }
    public function create($fname, $lname, $email, $message) {
        global $conn;
        $insert="insert into contact(first_name, last_name, email, message) values ('$fname', '$lname', '$email', '$message')";
        return mysqli_query ($conn,$insert);
    }
}