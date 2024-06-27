<?php
    function checkSessionTimeout() {
        //Include db connection
        include "db.php";
        //Check if session has expired
        if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $_SESSION['expires'])) {
            //If the account has been inactive for more than 1 hour
            session_unset();
            session_destroy();
            //Destroy cookies
            setcookie("user_id", "", time() - 3600, "/");
            setcookie("username", "", time() - 3600, "/");
            header("Location: auth/login.php?error=Session Expired! Please login again!");
            exit();

            //Close connection
            $conn->close();
        }
        //Update last activity time
        $_SESSION['last_activity'] = time();

        
    }
?>