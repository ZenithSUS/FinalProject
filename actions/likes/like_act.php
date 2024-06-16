<?php
    //Include db connection
    include "../../db.php";

    //Initialize session
    session_start();

    //Include queries
    include "../../queries/like.php";

    //Get post id and user id
    $postId = $_GET['post_id'];
    $userId = $_SESSION['user_id'];

    //Get type from url or using GET method
    $type = $_GET['type'];

    //Check of the user pressed like
    if(isset($_POST['likeForm'])) {
        //Call addLike function
        like($conn, $postId, $userId, $type);
    }

    //Check of the user pressed dislike
    if(isset($_POST['dislikeForm'])) {
        //Call removeLike function
        dislike($conn, $postId, $userId, $type);
    }

?>