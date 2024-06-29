<?php
    //Include db connection
    include "../db.php";
    //Intialize session 
    session_start();

    //Get data from form by POST method
    $username = $_POST['useracc'];
    $password = $_POST['password'];

    //Get the captcha information
    $secret = "6LdTPAMqAAAAAHO4REJfwlXjhCT9C-aKWgnQYMCR";
    $response = $_POST['g-recaptcha-response'];
    $remote_ip = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify";
 
    //Verify captcha
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}&remoteip={$remote_ip}");
    $response_data = json_decode($verify);


    //Check if form is submitted
    if(isset($_POST['submit'])) {
    
        //Check if fields are empty
        if(empty($username) || empty($password)) {
            header("Location: ../auth/login.php?error=Fill all the fields");
            exit();
        }

        //Check if the captcha is responded
        else if(!$response_data->success) {
            header("Location: ../auth/login.php?captchaError=Please verify that you are not a robot");
            exit();
        }

        //Check if all POST fields are not empty
        if(!isset($username) || !isset($password) || !isset($response)) {
            //Redirect to login page
            header("Location: ../auth/login.php");
            exit();
        }
            
        else {
            //Call login function
            include "../queries/auth.php";
            login($conn, $username, $password);
        }

    //Redirect to index page if user is logged in or the form is not submitted
    } else {
        header("Location: ../auth/login.php");
        exit();
    }
?>