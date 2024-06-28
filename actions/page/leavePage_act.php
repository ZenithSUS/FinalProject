<?php
    //Include db
    include "../../db.php";

    //Initialize session
    session_start();

    //Include queries
    include "../../queries/greek.php";

    //Check if user is logged in
    if(isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $greekId = $_GET['greek_id'];
        leavePage($conn, $userId, $greekId);
    } else {
        header("Location: ../../auth/login.php");
    }
?>