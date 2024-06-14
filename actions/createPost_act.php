<?php
    //Include queries
    include "../queries/post.php";

    //Include db connection
    include "../db.php";

    //Initialize session
    session_start();

    //Check if createPost is set or the form is submitted
    if(isset($_POST['createPost'])) { 
        $title = $_POST['title'];
        $content = $_POST['content'];
        $userId = $_SESSION['user_id'];
        createPost($conn, $title, $content, $userId);
    }
?>