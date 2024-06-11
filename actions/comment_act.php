<?php
    //Include queries
    include "queries/comment_queries.php";

    //Initialize session
    session_start();

    //Checks if the commentform is submitted
    if(isset($_POST['commentForm'])) {
        //Get data from url using GET method
        $postId = $_GET['post_id'];
        //Get user_id from session
        $userId = $_SESSION['user_id'];
        //Get data from form
        $comment = $_POST['comment'];
        //Call addComment function
        createComment($userId, $postId, $comment);
    }
?>
