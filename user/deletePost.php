<?php
    //Include queries
    include "../queries/post.php";

    //Include db connection
    include "../db.php";

    //Intialize session
    session_start();

    //Check if user is logged in
    if(!isset($_SESSION['user_id'])) {
        header("Location: ../auth/login.php");
    }
    //Call deletePost function
    deletePost($conn, $_GET['post_id']);
?>