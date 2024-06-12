<?php
    function checkSessionTimeout() {
        //Check if session has expired
        if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $_SESSION['exprires'])) {
            //If the account has been inactive for more than 1 hour
            session_unset();
            session_destroy();
            //Destroy cookies
            setcookie("user_id", "", time() - 3600, "/");
            header("Location: auth/login.php?error=Session Expired! Please login again!");
            exit();
        }
        //Update last activity time
        $_SESSION['last_activity'] = time();
    }
?>