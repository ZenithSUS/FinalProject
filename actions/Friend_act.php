<?php
    //Include queries
    include "../actions/queries.php";

    //Initialize session
    session_start();

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
            addFriend($userId, $friendId);
        } else {
            //Call removeFriend function
            deleteFriendRequest($userId, $friendId);
        }
    }

    //Checks if acceptFriendForm is submitted
    if(isset($_POST['acceptFriendForm'])) {
        //Get data from url using GET method
        $userId = $_SESSION['user_id'];
        $friendId = $_GET['user_id'];
        //Call acceptFriend function
        acceptFriendRequest($userId, $friendId);
    }

    //Checks if declineFriendForm is submitted
    if(isset($_POST['declineFriendForm'])) {
        //Get data from url using GET method
        $userId = $_SESSION['user_id'];
        $friendId = $_GET['user_id'];
        //Call declineFriend function
        deleteFriendRequest($userId, $friendId);
    }

    //Checks if deleteFriendForm is submitted
    if(isset($_POST['removeFriendForm'])) {
        //Get data from url using GET method
        $userId = $_SESSION['user_id'];
        $friendId = $_GET['user_id'];
        //Call deleteFriend function
        deleteFriend($userId, $friendId);
    }

?>