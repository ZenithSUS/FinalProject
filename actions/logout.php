<?php
    //Start session
    session_start();

    //Include db connection
    include "../db.php";

    //Destroy session if user is logged in
    if(isset($_SESSION['username']) || isset($_SESSION['user_id'])) {
       //Destroy session
       session_unset();
       session_destroy();

       //Close connection
       $conn->close();
    }

    //Redirect to login page
    echo "<script>
    alert('You have been logged out!');
    window.location.href = '../index.php'
    </script>";

?>