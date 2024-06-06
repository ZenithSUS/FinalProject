<?php
    session_start();

    if(isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
       session_destroy();
    }

    echo "<script>
    alert('You have been logged out!');
    window.location.href = '../index.php'
    </script>";

?>