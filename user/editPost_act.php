<?php
    include "../actions/queries.php";
    if(isset($_POST['editPost'])) {
        $postId = $_GET['post_id'];
        editPost($postId);
    }
?>