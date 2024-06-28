<?php
    //Initialize session
    session_start();

    //Include database connection
    include "../db.php";

    //Include queries
    include "../queries/auth.php";

    //Check if the recover form is submitted
    if(isset($_POST['recoverForm'])) {
        //Get data from form
        $acc = $_POST['acc'];
        //Call checkEmailOrUsername function
        checkEmailOrUsername($conn, $acc);
    }

    //Check if the recover password form is submitted
    if(isset($_POST['recoverPasswordForm'])) {
        //Get data from form
        $token = $_POST['token'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['cpassword'];
        //Call recoverPassword function
        resetPassword($conn, $token, $password, $confirmPassword);
    }

    //Redirect to index page if user is logged in or the form is not submitted
    if(!isset($_POST['recoverForm']) && !isset($_POST['recoverPasswordForm'])) {
        header("Location: ../index.php");
        exit();
    }

?>