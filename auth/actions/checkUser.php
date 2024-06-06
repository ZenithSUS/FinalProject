<?php
    include "../../db.php";
    $username = $_GET['user'];
    $sql = "SELECT * FROM users WHERE username = '$username'";

    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        echo "true";
    } else {
        echo "false";
    }
?>