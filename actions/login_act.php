<?php
    //Include db connection
    include "../db.php";
    //Intialize session 
    session_start();

    //Get data from form by POST method
    $username = $_POST['useracc'];
    $password = $_POST['password'];

    //Check if form is submitted
    if(isset($_POST['submit'])) {
        //Check if fields are empty
        if(empty($username) || empty($password)) {
            header("Location: auth/login.php?error=Fill all the fields");
            exit();
        }
        else {
           //Call login function
           include "queries.php";
           login($username, $password);
        }
    //Redirect to index page if user is logged in or the form is not submitted
    } else {
        header("Location: auth/login.php");
        exit();
    }
?>