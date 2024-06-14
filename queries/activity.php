<?php
    //Function to display activities
    function activities($conn, $userId) {
        //Write query and join tables on user_id
        $sql = "SELECT * FROM users JOIN activities ON users.user_id = activities.user_id 
        WHERE activities.user_id = '$userId' ORDER BY timestamp DESC";
        //Execute query
        $result = $conn->query($sql);
        //Display activities
        echo "<div class='profile-activity'>";
        echo "<h3 class='activity-title'>Activity</h3>";
        //Check if activities exist
        if($result !== false && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Format date
                $date = strtotime($row['timestamp']);
                $date = date('F d, Y', $date);
                $formattedDate = date('F d, Y', strtotime($date));
                echo "<div class='activity-box'>";
                echo "<h4>" . $formattedDate . "</h4>";
                echo "<p>" . $row['activity'] . "</p>";
                echo "</div>";
            }
        //Display no activities if none exist
        } else {
            echo "<p>No activity yet</p>";
        }
        echo "</div>";
    }

    //Function to add activity
    function addActivity($conn, $userId, $activity, $post_id=null, $comment_id=null) {
        //Check if post_id is not null or comment_id is null
        if($post_id != null && $comment_id == null) {
            $sql = "INSERT INTO activities (user_id, activity, post_id) VALUES ('$userId', '$activity', '$post_id')";
            
        }
        //Check if post_id is null or comment_id is not null
        if($post_id == null && $comment_id != null) {
            $sql = "INSERT INTO activities (user_id, activity, comment_id) VALUES ('$userId', '$activity', '$comment_id')";
        }

        //Check if post_id and comment_id are null
        if($post_id == null && $comment_id == null) {
            $sql = "INSERT INTO activities (user_id, activity) VALUES ('$userId', '$activity')";
        }

        //Execute query
        $conn->query($sql);

        //Check if query failed
        if(!$conn){
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
?>