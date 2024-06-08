<?php
    //Include db connection
    include "../db.php";
    //Get email from GET Method
    $email = $_GET['email'];
    $sql = "SELECT * FROM users WHERE email = '$email'";

    //Execute query
    $result = $conn->query($sql);

    //Check if email exists
    if($result->num_rows > 0) {
        echo "true";
    } else {
        echo "false";
    }
?>