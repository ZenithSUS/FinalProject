<?php
    //Function to get heroes
    function getGreeks($conn, $userId) {
        //Write query
        $sql = "SELECT * FROM greeks 
        JOIN user_groups ON greeks.greek_id = user_groups.greek_id 
        WHERE user_groups.user_id = ? ORDER BY name;";
        //Prepare statement
        $stmt = $conn->prepare($sql);
        //Bind parameters
        $stmt->bind_param("s", $userId);
        //Execute query
        $stmt->execute();
        //Get result
        $result = $stmt->get_result();
        //Check if heroes exist
        if($result !== false && $result->num_rows > 0) {
            // Display heroes
            while ($row = $result->fetch_assoc()) {
                //Clean the heroes text
                //Display heroes
                echo "<div class='hero-box'>";
                echo "<a class='greek-link' href='heroes.php?greek_id=" . $row['greek_id'] . "'>
                        <img src='img/gods/" . $row['image_url'] . "' alt='" . $row['name'] . "'>";
                echo "<h2>" . $row['name'] . "</h2></a>";
                echo "</div>";
            }
        }
    }


    //Function to get heroes inside in user folder
    function getGreeksUser($conn) {
        //Write query
        $sql = "SELECT greek_id, name, image_url FROM greeks ORDER BY name;";
        //Execute query
        $result = $conn->query($sql);
        //Check if heroes exist
        if($result !== false && $result->num_rows > 0) {
            // Display heroes
            while ($row = $result->fetch_assoc()) {
                //Clean the heroes text
                //Display heroes
                echo "<div class='hero-box'>";
                echo "<a class='greek-link' href='../heroes.php?greek_id=" . $row['greek_id'] . "'>
                        <img src='../img/gods/" . $row['image_url'] . "' alt='" . $row['name'] . "'>";
                echo "<h2>" . $row['name'] . "</h2></a>";        
                echo "</div>";
            }
        }
    }

    //Function to display greek groups 
    function getGreeksInfos($conn){
        //Write query
        $sql = "SELECT * FROM greeks ORDER BY name";
        $result = $conn->query($sql);

        if($result !== false && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='myth-container'>";
                echo "<div class='myth-box'>";
                echo "<div class='greek-name'>
                        <a href='heroes.php?greek_id=" . $row['greek_id'] . "'><img src='img/gods/" . $row['image_url'] . "' alt='" . $row['name'] . "'></a>";
                echo "<h2>" . $row['name'] . "</h2>   
                    </div>";

                echo "<div class='myth-info'>
                        <div class='myth-text'>" . $row['description'] . "</div>";
                echo "<a href='heroes.php?greek_id=" . $row['greek_id'] . "' class='myth-btn'>Read More</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        }
    }

    //Function to display specific myth
    function getSpecificGreekInfo($conn, $greek_id) {
        //Write queries
        $sql = "SELECT * FROM greeks WHERE greek_id = '$greek_id'";
        $sql2 = "SELECT COUNT(*) AS total_people FROM user_groups 
        JOIN greeks ON greeks.greek_id = user_groups.greek_id 
        WHERE greeks.greek_id = '$greek_id'";
        //Execute queries
        $result = $conn->query($sql);
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();
        if($result !== false && $result->num_rows > 0 && $result2 !== false && $result2->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                //If the Creator is Default, don't display the join button
                if($row['creator'] == "Default") {
                    $row['creator'] = "Greeks of the Gods";
                    echo "<div class='myth-container'>";
                    echo "<div class='myth-box'>";
                    echo "<div class='greek-name'>
                            <img src='img/gods/" . $row['image_url'] . "' alt='" . $row['name'] . "'>";
                    echo "<h2>" . $row['name'] . "</h2>
                         <p>Creator: <strong>" . $row['creator'] . "</strong></p>
                         <p>Total people joined: " . $row2['total_people'] . "</p>";
                    echo "</div>";
                    echo "<div class='myth-info'>
                            <div>" . $row['description'] . "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                //If the Creator is not Default, display the join button
                } else {
                    echo "<div class='myth-container'>";
                    echo "<div class='myth-box'>";
                    echo "<div class='greek-name'>
                            <img src='img/gods/" . $row['image_url'] . "' alt='" . $row['name'] . "'>";
                    echo "<h2>" . $row['name'] . "</h2>
                        <p>Creator: " . $row['creator'] . "</p>
                        <p>Total people joined: " . $row2['total_people'] . "</p>"; 
                    if(isset($row2['user_id']) && $row2['user_id'] == $_SESSION['user_id']) {
                        echo "<a class='myth-btn' href='leave_act.php?greek_id=" . $row['greek_id'] . "' class='myth-btn'>Leave Group</a>";
                    } else {
                        echo "<a class='myth-btn' href='join_act.php?greek_id=" . $row['greek_id'] . "' class='myth-btn'>Join Group</a>";
                    }    
                    echo  "</div>";
                    echo "<div class='myth-info'>
                            <div>" . $row['description'] . "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                } 
            } 
        }

        //Show posts related to myth
        $sql = "SELECT posts.*, users.profile_pic, 
        users.username, greeks.name AS greek FROM posts 
        JOIN users ON posts.author = users.user_id 
        JOIN greeks ON posts.greek_group = greeks.greek_id WHERE posts.greek_group = ?";
        //Prepare statement
        $stmt = $conn->prepare($sql);
        //Bind parameters
        $stmt->bind_param("s", $greek_id);
        //Execute statement
        $stmt->execute();
        //Get result
        $result = $stmt->get_result();

        if($result !== false && $result->num_rows > 0) {
            //Loop through results
            while ($row = $result->fetch_assoc()) {
                //Get post date and time
                $created_date = $row['created_at'];
                //Posts Containers
                echo "<div class='post'>";
                echo "<p class='author'><a href='user/profile.php?user_id=" . $row['author'] . "'>";
                //Check if profile picture exists
                if ($row['profile_pic'] != NULL) {
                    echo "<img src='img/u/" . $row['profile_pic'] . "' alt='user' class='profilePic'>";
                // Provide a default picture if no profile picture exists
                } else {
                    echo "<img src='img/default.jpg' alt='user' class='profilePic'>";
                }
                echo "</a>";
                //Display username and date
                echo "Posted by <a class='username' href='user/profile.php?user_id=" . $row['author'] . "'>" . $row['username'] . "</a> on " . date('F j, Y, g:i a', strtotime($created_date));
                if($row['greek_group'] != NULL) {
                    echo " in " . "<a class='greek' href='heroes.php?greek_id=" . $row['greek_group'] . "'><strong>" .$row['greek'] . "</strong></a>";
                }
                echo "</p>";
                //Display title and content
                echo "<a class='title' href='user/currentPost.php?post_id=" . $row['post_id'] . "&title=" . $row['title'] . "'><h3>" . $row['title'] . "</h3>";
                echo "<p>" . $row['content'] . "</p></a>";

                //Get the user vote type
                $sql2 = "SELECT vote_type FROM likes JOIN users ON likes.liker = users.user_id 
                WHERE likes.post_id = '" . $row['post_id'] . "' 
                AND likes.liker = '" . $_SESSION['user_id'] . "'";
                $result2 = $conn->query($sql2);
                $row2 = $result2->fetch_assoc();
                if($result2 !== false && $result2->num_rows > 0) {
                    $voteType = $row2['vote_type'];
                } else {
                    $voteType = null;
                }

                //Display likes and dislikes
                echo "<form action='actions/likes/like_act.php?post_id=" . $row['post_id'] . "&type=" . $voteType . "' method='POST' class='vote'>
                        <p><button type='submit' name='likeForm'><img class='vote-emoji' src='img/misc/like.png' alt='like'> " . $row['likes'] . " </button></p>
                        <p><button type='submit' name='dislikeForm'><img class='vote-emoji' src='img/misc/dislike.png' alt='dislike'> " . $row['dislikes'] . " </button></p>
                    </form>";

                //Get number of comments
                $sql2 = "SELECT COALESCE(COUNT(*), 0) AS total_comments FROM comments WHERE post_id = '" . $row['post_id'] . "'";
                $result2 = $conn->query($sql2);
                $row2 = $result2->fetch_assoc();

                //Display comments
                echo "<hr>";
                echo "<a class='commentLink' href='user/currentPost.php?post_id=" . $row['post_id'] . "'>comments " . $row2['total_comments'] . "</a>";
                echo "</div>";
            }
        //Else display no posts yet
        } else {
            echo "<div class='post'>";
            echo "<p>No posts yet</p>";
            echo "</div>";
        }
    }

    //function to get users greek group pages joined
    function getUserGroupPages($conn){
        //Write query
        $sql = "SELECT greeks.greek_id, greeks.name FROM greeks 
        JOIN user_groups ON greeks.greek_id = user_groups.greek_id
        AND user_groups.user_id = ? ORDER BY name;";

        //Prepare statement
        $stmt = $conn->prepare($sql);
        //Bind parameters
        $stmt->bind_param("s", $_SESSION['user_id']);
        //Execute statement
        $stmt->execute();
        //Get result
        $result = $stmt->get_result();


        //Check if heroes exist
        if($result !== false && $result->num_rows > 0) {
            // Display heroes
            echo "<select id='greek-select' name='greek' class='group-select'>";
                echo "<option value=''>Select Greek</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['greek_id'] . "'>" . $row['name'] . "</option>";
            }
            echo "</select>";
        } else {
            echo "No greeks found";
        }
    }
?>