<?php
    //Function to get all friends
    function getFriends($conn, $userId) {
        //Write query
        $sql = "SELECT * FROM friends JOIN users 
        ON friends.user_id = users.user_id 
        WHERE friends.friend_id = ?";
        //Prepare and Bind
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $userId);
        //Execute Query
        $stmt->execute();
        //Get result
        $result = $stmt->get_result();
        //Close connection
        
        //Return result
        return $result;
    }
    //Function the get number of friend requests
    function getFriendRequestCount($conn, $userId) {
        //Write query
        $sql = "SELECT * FROM friend_requests WHERE requestee_id = ? AND status = 'pending'";
        //Prepare and Bind
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $userId);
        //Execute Query
        $stmt->execute();
        //Get result
        $result = $stmt->get_result();
        //Get number of rows
        $count = $result->num_rows;
        //Close connection
        $stmt->close();
        
        //Return number of friend requests
        return $count;
    }

    //Function the get number of friend requests if the directiory is in user folder
    function getFriendRequestCountUser($conn, $userId) {
        //Write query
        $sql = "SELECT * FROM friend_requests WHERE requestee_id = ? AND status = 'pending'";
        //Prepare and Bind
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $userId);
        //Execute Query
        $stmt->execute();
        //Get result
        $result = $stmt->get_result();
        //Get number of rows
        $count = $result->num_rows;
        //Close connection
        $stmt->close();
        
        //Return number of friend requests
        return $count;
    }


    //Function to get friend request
    function getFriendRequests($conn, $userId) {
        //Write query
        $sql = "SELECT * FROM users JOIN friend_requests ON users.user_id = friend_requests.requester_id 
        WHERE friend_requests.requestee_id = ? AND friend_requests.status = 'pending'";
        //Prepare and Bind
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $userId);
        //Execute Query
        $stmt->execute();
        //Get result
        $result = $stmt->get_result();
        //Close connection
        $stmt->close();
        
        //Return result
        return $result;
    }

    //Function to get total friends
    function getTotalFriends($conn, $userId) {
        //Write query
        $sql = "SELECT COUNT(*) AS total FROM friends WHERE user_id = ?";
        //Prepare and Bind
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $userId);
        //Execute Query
        $stmt->execute();
        //Get result
        $result = $stmt->get_result();
        //Get number of rows
        $row = $result->fetch_assoc();
        $total = $row['total'];
        //Close connection
        $stmt->close();
        
        //Return result
        return $total;
    }


    //Function to add friend
    function addFriend($conn, $userId, $friendId) {
        $sql = "INSERT INTO friend_requests (id, requester_id, requestee_id) VALUES (UUID(), ?, ?)";
        //Prepare and Bind
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $userId, $friendId);
        //Execute Query
        $stmt->execute();

        //Redirect back to profile
        header("Location: ../user/profile.php?user_id=" . $friendId);
        
        //Close connection
        $stmt->close();
    }

    //Function to delete friend request
    function deleteFriendRequest($conn, $userId, $friendId) {
        //Write Query
        $sql = "UPDATE friend_requests SET 
        status = 'rejected' 
        WHERE requester_id = ? AND requestee_id = ? 
        OR requester_id = ? AND requestee_id = ?";
        //Prepare and Bind
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $userId, $friendId, $friendId, $userId);
        //Execute Query
        $stmt->execute();

        //Write and Query
        $sql = "DELETE FROM friend_requests 
        WHERE requester_id = ? AND requestee_id = ? AND status = 'rejected'
        OR requester_id = ? AND requestee_id = ? AND status = 'rejected'";
        //Prepare and Bind
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $userId, $friendId, $friendId, $userId);
        //Execute Query
        $stmt->execute();
        //Redirect back to profile
        header("Location: ../user/profile.php?user_id=" . $friendId);
        //Close connection
        $stmt->close();
    }

    //Function to delete friend
    function deleteFriend($conn, $userId, $friendId) {
        //Write and Query
        $sql = "DELETE FROM friends WHERE user_id = ? AND friend_id = ?
        OR user_id = ? AND friend_id = ?";
        //Prepare and Bind
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $userId, $friendId, $friendId, $userId);
        //Execute Query
        $stmt->execute();

        //Delete friend request
        deleteFriendRequest($conn, $userId, $friendId);
        //Redirect back to profile
        header("Location: ../user/profile.php?user_id=" . $friendId);
        //Close connection
        $stmt->close();
    }

    //Function to get friend request status
    function getFriendRequestStatus($conn, $userId, $friendId) {
        //Write and Query the OR statement is to ensure that the 
        //requester and requestee are not the same
        $sql = "SELECT * FROM friend_requests WHERE requester_id = ? AND requestee_id = ?
        OR requester_id = ? AND requestee_id = ?";
        //Prepare and Bind
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $userId, $friendId, $friendId, $userId);
        //Execute Query
        $stmt->execute();
        //Get result
        $result = $stmt->get_result();
        //Get rows using fetch_assoc
        $row = $result->fetch_assoc();

        //Check if friend request exists
        if($result !== false && $result->num_rows > 0) {
            //Check if friend request is pending by using the requester id
            //To check if the user is the requester
            if($row['requester_id'] == $userId) {
                return $row['status'];
            } else {
                return "waiting";
            }
            
        //No friend request exists
        } else {
            return;
        }

        //Close connection
        $stmt->close();
    }

    //Function to accept friend request
    function acceptFriendRequest($conn, $userId, $friendId) {
        //Write and Query
        $sql = "UPDATE friend_requests SET status = 'accepted' WHERE requester_id = ? AND requestee_id = ?";
        //Prepare and Bind
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $friendId, $userId);
        //Execute Query
        $stmt->execute();

        //Insert Friend
        $sql = "INSERT INTO friends (id, user_id, friend_id) VALUES (UUID(), ?, ?)";
        //Prepare and Bind
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $friendId, $userId);
        //Execute Query
        $stmt->execute();

        //Insert Friend to the other user
        $sql = "INSERT INTO friends (id, user_id, friend_id) VALUES (UUID(), ?, ?)";
        //Prepare and Bind
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $userId, $friendId);
        //Execute Query
        $stmt->execute();

        $sql = "DELETE FROM friend_requests WHERE requester_id = ? OR requester_id = ?
        AND status = 'accepted'";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $userId, $friendId);
        $stmt->execute();


        //Redirect back to profile
        header("Location: ../user/profile.php?user_id=" . $friendId);
        //Close connection
        $stmt->close();
    }
?>