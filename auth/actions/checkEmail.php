<?php
    include "../../db.php";
    $email = $_GET['email'];
    $sql = "SELECT * FROM users WHERE email = '$email'";

    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        echo "true";
    } else {
        echo "false";
    }
?>