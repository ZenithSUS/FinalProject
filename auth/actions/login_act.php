<?php
    include "../../db.php";
    session_start();

    $username = $_POST['useracc'];
    $password = $_POST['password'];

    if(isset($_POST['submit'])) {
        if(empty($username) || empty($password)) {
            header("Location: ../login.php?error=Fill all the fields");
            exit();
        }
        else {
           include "queries.php";
           login($username, $password);
        }
    } else {
        header("Location: ../login.php");
        exit();
    }
?>