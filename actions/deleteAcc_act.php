<?php
    //Intialize session
    session_start();

    //Include db connection
    include "../db.php";

    //Include queries
    include "../queries/profile.php";
    
    //Check if user is logged in
    if(isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        deleteAccount($conn, $userId);
    } else {
        header("Location: ../auth/login.php");
    }

?>