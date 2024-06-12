<?php
    //Include queries
    include "../queries/post.php";

    //Call deletePost function
    deletePost($conn, $_GET['post_id']);
?>