<?php
    function like($conn, $postId, $userId, $type) {
        //Add like
        $sql = "INSERT INTO likes (post_id, user_id, type) VALUES (?, ?, ?)";
        //Prepare statement
        $stmt = $conn->prepare($sql);
        //Bind parameters
        $stmt->bind_param("iis", $postId, $userId, $type);
        //Execute statement
        $stmt->execute();
        //Close statement
        $stmt->close();
    }

    function dislike($conn, $postId, $userId, $type) {
        //Remove like
        $sql = "DELETE FROM likes WHERE post_id = ? AND user_id = ? AND type = ?";
        //Prepare statement
        $stmt = $conn->prepare($sql);
        //Bind parameters
        $stmt->bind_param("iis", $postId, $userId, $type);
        //Execute statement
        $stmt->execute();
        //Close statement
        $stmt->close();
    }
?>