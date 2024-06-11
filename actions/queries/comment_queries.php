<?php
    //Function to display comments
    function comments() {
        //Include queries
        include "../db.php";
        //Get post id from url or using GET method
        $postId = $_GET['post_id'];
        //Write query and join tables to display comments
        $sql = "SELECT * FROM comments 
        JOIN users ON comments.author = users.user_id 
        WHERE comments.post_id = '$postId' ORDER BY created_at DESC LIMIT 3";
        //Execute query
        $result = $conn->query($sql);
        //Check if comments exist
        if($result !== false && $result->num_rows > 0) {
            // Display comments
            while ($row = $result->fetch_assoc()) {
                //Display comments
                echo "<div class='comment'>";
                //Display username and date of comment
                echo "<p class='author'> <a href='profile.php?user_id=" . $row['author'] . "'>";
                //Check if profile pic exists
                if($row['profile_pic'] != NULL) {
                    echo "<img src='../img/u/" . $row['profile_pic'] . "' alt='user' class='profilePic'>";
                //Display default profile pic if profile pic does not exist
                } else {
                    echo "<img src='../img/default.jpg' alt='user' class='profilePic'>";
                }
                echo "</a>";
                //Display username and date
                echo $row['username'] . " " . date('F j, Y, g:i a', strtotime($row['created_at'])) . "</p>";
                //Display comment
                echo "<p>" . $row['content']. "</p>";
                echo "</div>";
            }
        //Display message if no comments
        } else {
            echo "<div class='comment'>";
            echo    "<p>No comments yet</p>";
            echo "</div>";
        }
        //Close connection
        $conn->close();
    }

    function createComment($userId, $postId, $content) {
        //Include database
        include "../db.php";
        if(isset($_POST['commentForm'])) {
            //Check if content is set and not null to create comment
            if(isset($content) && !empty($content) && !is_null($content)) {
                //Write query
                $sql = "INSERT INTO comments (comment_id, author, post_id, content) VALUES (?, ?, ?, ?)";
                //Prepare query
                $stmt = $conn->prepare($sql);
                //Get unique comment id
                $comment_id = uniqid();
            
                //Bind parameters
                $stmt->bind_param("ssss", $comment_id, $userId, $postId, $content);
                //Execute query
                $stmt->execute();

                //Check if query executed
                if($stmt == true) {
                //fetch the inserted comment by using and getting comment id
                    $sql = "SELECT comments.comment_id, posts.title FROM comments 
                    JOIN posts ON comments.post_id = posts.post_id 
                    WHERE comments.comment_id = '$comment_id'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();

                    //include queries
                    include "queries/activity_queries.php";
                    //Get title from posts and comment relationship
                    $title= $row['title'];
                    addActivity($userId, "commennted on a post titled " . $title . "", NULL, $row['comment_id']);
                }
            }
            //Get post id from url or using GET method
            $postId = $_GET['post_id'];
            header("Location: ../user/currentPost.php?post_id=" . $postId);
        }

    }
?>