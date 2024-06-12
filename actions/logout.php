<?php
    //Start session
    session_start();

    //Destroy session if user is logged in
    if(isset($_SESSION['username']) || isset($_SESSION['user_id'])) {
       //Destroy session
       session_unset();
       session_destroy();

       //Destroy cookies
       setcookie("user_id", "", time() - 3600, "/");
    }

    //Redirect to login page
    echo "<script>
    alert('You have been logged out!');
    window.location.href = '../index.php'
    </script>";

?>