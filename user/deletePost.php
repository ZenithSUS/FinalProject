<?php
    //Include queries
    include "../actions/queries.php";

    //Call deletePost function
    deletePost($_GET['post_id']);
?>