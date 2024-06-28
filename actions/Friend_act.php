<?php
    //Include queries
    include "../db.php";
    include "../queries/friend.php";

    //Initialize session
    session_start();

    //Check if the get methods and the session are set
    if(!isset($_SESSION['user_id']) || !isset($_GET['status'])) {
        header("Location: ../index.php");
    }

    //Check if user is logged in
    if(isset($_SESSION['user_id'])) {
        //Checks if the friendform is submitted
        if(isset($_POST['friendForm'])) {
            //Get data from url using GET method
            $userId = $_SESSION['user_id'];
            //Get data from form
            $friendId = $_GET['user_id'];
            //Get Status
            $status = $_GET['status'];
            //Call addFriend function
            if(!$status) {
                //Call addFriend function
                addFriend($conn, $userId, $friendId);
            } else {
                //Call removeFriend function
                deleteFriendRequest($conn, $userId, $friendId);
            }
        }

        //Checks if acceptFriendForm is submitted
        if(isset($_POST['acceptFriendForm'])) {
            //Get data from url using GET method
            $userId = $_SESSION['user_id'];
            $friendId = $_GET['user_id'];
            //Call acceptFriend function
            acceptFriendRequest($conn, $userId, $friendId);
        }

        //Checks if declineFriendForm is submitted
        if(isset($_POST['declineFriendForm'])) {
            //Get data from url using GET method
            $userId = $_SESSION['user_id'];
            $friendId = $_GET['user_id'];
            //Call declineFriend function
            deleteFriendRequest($conn, $userId, $friendId);
        }

        //Checks if deleteFriendForm is submitted
        if(isset($_POST['removeFriendForm'])) {
            //Get data from url using GET method
            $userId = $_SESSION['user_id'];
            $friendId = $_GET['user_id'];
            //Call deleteFriend function
            deleteFriend($conn, $userId, $friendId);
        }

        //Check if in the friends page is press accept request
        if(isset($_POST['accept'])) {
            //Get data from url using GET method
            $userId = $_SESSION['user_id'];
            $friendId = $_GET['user_id'];
            //Call acceptFriend function
            acceptFriendRequest($conn, $userId, $friendId);
        }

        //Check if in the friends page is press decline request
        if(isset($_POST['decline'])) {
            //Get data from url using GET method
            $userId = $_SESSION['user_id'];
            $friendId = $_GET['user_id'];
            //Call declineFriend function
            deleteFriendRequest($conn, $userId, $friendId);
        }

    } else {
        header("Location: ../auth/login.php");
    }

?>