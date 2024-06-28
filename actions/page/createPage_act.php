<?php
    //Initialize session
    session_start();

    //Include database connection
    include '../../db.php';

    //Include queries
    include '../../queries/greek.php';

    //Check if the user is logged in
    if(!isset($_SESSION['user_id']) || !isset($_COOKIE['user_id'])){
        header("Location: ../../auth/login.php");
    }

    //Get user id
    $userId = $_SESSION['user_id'];

    //Get data from form in METHOD POST
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_FILES['greek_image'];

    //Check if the create page form is submitted
    if(isset($_POST['createPage'])) {
        //Call createPage function
        createPage($conn, $title, $description, $image, $userId);
    }

    //If the create page form is not submitted
    else {
        header("Location: ../../index.php");
    }
?>