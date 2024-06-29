<?php
    //Initialize session
    session_start();

    //Include db connection
    include "../db.php";

    //Include queries
    include "../queries/profile.php";

    //Get user id
    $userId = $_SESSION['user_id'];
    
    
    //Check if editProfile form is submitted
    if(isset($_POST['editProfile'])) {
        //Get form data
        $username = $_POST['username'];
        $email = $_POST['email'];
        //Check if profile pic is uploaded
        if(isset($_FILES['profilePic'])) {
            $profilePic = $_FILES['profilePic'];
        } else {
            $profilePic = null;
        }
        $bio = $_POST['bio'];

        //Call editProfile function
        editProfile($conn, $userId, $username, $email, $profilePic, $bio);
    }

    //Check if editPass form is submitted
    if(isset($_POST['editPass'])) {
        //Get form data
        $password = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $confirmNewPassword = $_POST['confirm_password'];
        //Call editPass function
        editPass($conn, $userId, $password, $newPassword, $confirmNewPassword);
    }

    //If neither form is submitted
    if(!isset($_POST['editProfile']) && !isset($_POST['editPass'])) {
        //If the user is not logged in
        if(!isset($_SESSION['user_id'])) {
            header("Location: ../auth/login.php");
            exit();
        } else {
            header("Location: ../user/profile.php?user_id=$userId");
            exit();
        }
    }

?>