<?php
    //Connect to database
    $conn = new mysqli("localhost", "root", "", "greekmyth");

    //Check connection if failed
    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        // echo "Connected successfully";
    }

?>