<?php
    //Include db connection
    include "../../db.php";

    //Initialize session
    session_start();

    //Include queries
    include "../../queries/commentLike.php";

    //Get post id and user id
    $commentId = $_GET['comment_id'];
    $postId = $_GET['post_id'];
    $userId = $_SESSION['user_id'];

    //Get type from url or using GET method
    $type = $_GET['type'];

    //Check if the user is logged in
    if(!isset($_SESSION['user_id'])) {
        header("Location: ../../auth/login.php");
    }

    //Check if the get methods are set
    if(!isset($commentId) || !isset($postId) || !isset($userId) || !isset($type)) {
        header("Location: ../../index.php");
    }
    
    //Check of the user pressed like
    if(isset($_POST['likeForm'])) {
        //Call addLike function
        like($conn, $postId, $commentId, $userId, $type);
    }

    //Check of the user pressed dislike
    if(isset($_POST['dislikeForm'])) {
        //Call removeLike function
        dislike($conn, $postId, $commentId, $userId, $type);
    }

?>