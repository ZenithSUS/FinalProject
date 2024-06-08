<?php
    //Include db connection
    include "../db.php";

    //Get username from GET Method
    $username = $_GET['user'];
    $sql = "SELECT * FROM users WHERE username = '$username'";

    //Execute query
    $result = $conn->query($sql);

    //Check if username exists
    if($result->num_rows > 0) {
        echo "true";
    } else {
        echo "false";
    }
?>