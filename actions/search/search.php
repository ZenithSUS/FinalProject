<?php
    //Include db
    include "../../db.php";

    //Initialize session
    session_start();

    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }

    //Get search input
    $searchQuery = $conn->real_escape_string($_GET['q']);

    //Write query
    $sql = "SELECT user_id, username, profile_pic FROM users WHERE username 
    LIKE CONCAT('%', ?, '%') AND user_id != ?";
    //Prepare and Bind
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $searchQuery, $_SESSION['user_id']);
    //Execute Query
    $stmt->execute();
    //Get Result
    $result = $stmt->get_result();

    //Check if there are any results
    //Get number of rows
    if($result !== false && $result->num_rows > 0 && $searchQuery !== "") {
        while($rows = $result->fetch_assoc()) {
            $user_id = $rows['user_id'];
            $username = $rows['username'];
            $profile_pic = $rows['profile_pic'];
            if($profile_pic == null) {
                echo "<a class='item' href='user/profile.php?user_id=$user_id' data-user-id='$user_id'> 
                <img src='img/default.jpg' alt='user'> $username</a>";
            } else {
                echo "<a class='item' href='user/profile.php?user_id=$user_id' data-user-id='$user_id'> 
                <img src='img/u/$profile_pic' alt='user'> $username</a>";
            }
           
        }
    } else {
        echo "<p class='item'>No results found</p>";
    }
    //Close connection
    
    //Return result
    return $result;

?>