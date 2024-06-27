<?php
    //Include queries
    include "../queries/post.php";
    //include db connection
    include "../db.php";

    //Initialize session
    session_start();

    //Check if user is logged in
    if(isset($_SESSION['user_id'])) {
        //Checks if the editform is submitted
        if(isset($_POST['editPost'])) {
            //Get data from url using GET method
            $postId = $_GET['post_id'];
            //Call editPost function
            editPost($conn, $postId);
        } else {
            header("Location: ../index.php");
        }
    } else {
        header("Location: ../auth/login.php");
    }
?>