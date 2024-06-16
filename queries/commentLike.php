<?php
    function like($conn, $postId, $commentId, $userId, $type) {
        $type = "like";
        // Check if the user has already liked the post
        $sql = "SELECT * FROM likes WHERE comment_id = ? AND liker = ?";
        // Prepare statement
        $stmt = $conn->prepare($sql);
        // Bind parameters
        $stmt->bind_param("ss", $commentId, $userId);
        // Execute statement
        $stmt->execute();
        // Get result
        $result = $stmt->get_result();
        $hasLiked = $result->fetch_assoc();
    
        // Check if the user has already liked the post
        if ($hasLiked) {
            // Get the previous like type
            $existingLike = $hasLiked['vote_type'];
    
            // Check if the like type is not the same as the previous like type
            if ($existingLike !== $type) {
                // Update like to dislike
                $sql = "UPDATE likes SET vote_type = ? WHERE comment_id = ? AND liker = ?";
                // Prepare statement
                $stmt = $conn->prepare($sql);
                // Bind parameters
                $stmt->bind_param("sss", $type, $commentId, $userId);
                // Execute statement
                $stmt->execute();
    
                // Adjust post likes and dislikes counts
                updateVoteCounts($conn, $commentId, $existingLike, $type);
            } else {
                // Call the undoLike function
                undoVote($conn, $commentId, $userId, $type);
            }
        } else {
            // User has not liked the post before
            addVote($conn, $commentId, null, $type);
            // Call function insert like
            insertVote($conn, $commentId, $userId, $type);
        }
    
        // Close statement
        $stmt->close();
    
        // Redirect back to current post
        header("Location: ../../user/currentPost.php?post_id=" . $postId);
    }
    

    function dislike($conn, $postId, $commentId, $userId, $type) {
        $type = "dislike";
        // Check if the user has already disliked the post
        $sql = "SELECT * FROM likes WHERE comment_id = ? AND liker = ?";
        // Prepare statement
        $stmt = $conn->prepare($sql);
        // Bind parameters
        $stmt->bind_param("ss", $commentId, $userId);
        // Execute statement
        $stmt->execute();
        // Get result
        $result = $stmt->get_result();
        $hasDisliked = $result->fetch_assoc();
    
        // Check if the user has already disliked the post
        if ($hasDisliked) {
            // Get the previous like type
            $existingLike = $hasDisliked['vote_type'];
            
            // Check if the like type is not the same as the previous like type
            if ($existingLike !== $type) {
                // Update like to dislike
                $sql = "UPDATE likes SET vote_type = ? WHERE comment_id = ? AND liker = ?";
                // Prepare statement
                $stmt = $conn->prepare($sql);
                // Bind parameters
                $stmt->bind_param("sss", $type, $commentId, $userId);
                // Execute statement
                $stmt->execute();
    
                // Adjust post likes and dislikes counts
                updateVoteCounts($conn, $commentId, $existingLike, $type);
            } else {
                // Call the undoDislike function
                undoVote($conn, $commentId, $userId, $type);
            }
        } else {
            // User has not disliked the post before
            addVote($conn, $commentId, null, $type);
            // Call function insert dislike
            insertVote($conn, $commentId, $userId, $type);
        }
    
        // Close statement
        $stmt->close();
        // Redirect back to current post
        header("Location: ../../user/currentPost.php?post_id=" . $postId);
    }
    

    //Function to add likes to a post
    function addVote($conn, $commentId, $previousLikeType, $newLiketype) {
            //Check if the previous like type is not the same as the new like type
            if($previousLikeType !== $newLiketype) {
                if($newLiketype == "like") {
                    $sql = "UPDATE comments SET likes = likes + 1 WHERE comment_id = ?";
                    //Prepare statement
                    $stmt = $conn->prepare($sql);
                    //Bind parameters
                    $stmt->bind_param("s", $commentId);
                    //Execute statement
                    $stmt->execute();
                    //Close statement
                    $stmt->close();
                }

                if($newLiketype == "dislike") {
                    $sql = "UPDATE comments SET dislikes = dislikes + 1 WHERE comment_id = ?";
                    //Prepare statement
                    $stmt = $conn->prepare($sql);
                    //Bind parameters
                    $stmt->bind_param("s", $commentId);
                    //Execute statement
                    $stmt->execute();
                    //Close statement
                    $stmt->close();
                }
            }
    }

    //Function to insert like
    function insertVote($conn, $commentId, $userId, $type){
        $sql = "INSERT INTO likes (like_id, comment_id, liker, vote_type) VALUES (?, ?, ?, ?)";
        //Prepare statement
        $stmt = $conn->prepare($sql);
        //Bind parameters
        $like_id = uniqid();
        $stmt->bind_param("ssss", $like_id, $commentId, $userId, $type);
        //Execute statement
        $stmt->execute();
        //Close statement
        $stmt->close();
    }

    //Function to undo likes from a post
    function undoVote($conn, $commentId, $userId, $type) {

        //if the type is like
        if($type == "like") {
            //Increment likes
            $sql = "UPDATE comments SET likes = likes - 1 WHERE comment_id = ?";
            //Prepare statement
            $stmt = $conn->prepare($sql);
            //Bind parameters
            $stmt->bind_param("s", $commentId);
            //Execute statement
            $stmt->execute();
            
        }

        //if the type is dislike
        if($type == "dislike") {
            //Increment dislikes
            $sql = "UPDATE comments SET dislikes = dislikes - 1 WHERE comment_id = ?";
            //Prepare statement
            $stmt = $conn->prepare($sql);
            //Bind parameters
            $stmt->bind_param("s", $commentId);
            //Execute statement
            $stmt->execute();
        }

        //Remove like
        $sql = "DELETE FROM likes WHERE liker = ? AND comment_id = ? AND vote_type = ?";
        //Prepare statement
        $stmt = $conn->prepare($sql);
        //Bind parameters
        $stmt->bind_param("sss", $userId, $commentId, $type);
        //Execute statement
        $stmt->execute();
        //Close statement
        $stmt->close();
    }

    function updateVoteCounts($conn, $commentId, $previousType, $newType) {
        // Update post likes and dislikes counts based on previous and new vote types

        // Set SQL statement based on previous and new vote types
        if ($previousType == "like" && $newType == "dislike") {
            $sql = "UPDATE comments SET likes = likes - 1, dislikes = dislikes + 1 WHERE comment_id = ?";
        } elseif ($previousType == "dislike" && $newType == "like") {
            $sql = "UPDATE comments SET dislikes = dislikes - 1, likes = likes + 1 WHERE comment_id = ?";
        }

        // Prepare and execute statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $commentId);
        $stmt->execute();

        // Close statement
        $stmt->close();
    }
    
?>