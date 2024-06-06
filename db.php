<?php
    $conn = new mysqli("localhost", "root", "", "greekmyth");

    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>