<?php
    //Include queries
    include "../queries/comment.php";
    //include db connection
    include "../db.php";

    //Initialize session
    session_start();


    if(isset($_SESSION['user_id']) && isset($_GET['post_id']) && !empty($_SESSION['user_id']) && !empty($_GET['post_id'])) {
        //Checks if the commentform is submitted
        if(isset($_POST['commentForm'])) {
            //Get data from url using GET method
            $postId = $_GET['post_id'];
            //Get user_id from session
            $userId = $_SESSION['user_id'];
            //Get data from form
            $comment = $_POST['comment'];
            //Call addComment function
            createComment($conn, $userId, $postId, $comment);
        }

        //Checks if the replyform is submitted
        if(isset($_POST['replyForm'])) {
            //Get data from url using GET method
            $commentId = $_GET['comment_id'];
            $postId = $_GET['post_id'];
            //Get user_id from session
            $userId = $_SESSION['user_id'];
            //Get data from form
            $content = $_POST['content'];
            //Call addReply function
            createReply($conn, $userId, $postId, $commentId, $content);
        }

        //Check if the delete comment is submitted
        if(isset($_POST['deleteComment'])) {
            //Get data from url using GET method
            $postId = $_GET['post_id'];
            $commentId = $_GET['comment_id'];

            //Call deleteComment function
            deleteComment($conn, $commentId, $postId);
        }

    } else {
        header("Location: ../auth/login.php");
    }
?>
