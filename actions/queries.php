<?php
    //Function to login
    function login($username, $password) {
        include "../db.php";
        $sql = "SELECT * FROM users WHERE username=? OR email=?";
        $stmt = $conn->prepare($sql);
        if(!$stmt->prepare($sql)) {
            header("Location: ../auth/login.php?error=sqlerror");
            exit();
        } else {
            $stmt->bind_param("ss", $username, $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows === 0) {
                header("Location: ../auth/login.php?error=No user exists in the database");
                exit();
            }
            else {
                $row = $result->fetch_assoc();
                if(password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['username'];
                    header("Location: ../index.php");
                } else {
                    header("Location: ../auth/login.php?error=Incorrect username or password");
                }
                exit();
            }
        }
    }

    //Function to register
    function register($username, $email, $password) {
        include "../db.php";
        $sql = "INSERT INTO users (user_id, username, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if(!$stmt->prepare($sql)) {
           die("SQL error: " . $conn->error);
            exit();
        } else {
            $user_id = mysqli_real_escape_string($conn, uniqid());
            $stmt->bind_param("ssss", $user_id, $username, $email, $hashed_password);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            echo "<script>alert('Registered successfully!')</script>";
            echo "<script>window.location.href = '../auth/uploadProfile.php';</script>";
        }
    }

    //Function to display posts in random order
    function posts() {    
        include "db.php";
        $sql = "SELECT * FROM posts JOIN users ON posts.author = users.user_id
        ORDER BY RAND()";
        $result = $conn->query($sql);
        if($result !== false && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $created_date = $row['created_at'];
                echo "<div class='post'>";
                echo "<p class='author'><a href='user/profile.php?user_id=" . $row['author'] . "'>";
                if ($row['profile_pic'] != NULL) {
                    echo "<img src='img/u/" . $row['profile_pic'] . "' alt='user' class='profilePic'>";
                } else {
                    echo "<img src='img/default.jpg' alt='user' class='profilePic'>"; // Provide a default text if no profile picture exists
                }
                echo "</a>";
                echo $row['username'] . " " . date('F j, Y, g:i a', strtotime($created_date)) . "</p>";
                echo "<a class='title' href='user/currentPost.php?post_id=" . $row['post_id'] . "&title=" . $row['title'] . "'><h3>" . $row['title'] . "</h3>";
                echo "<p>" . $row['content'] . "</p></a>";
                echo "<div class='vote'>
                        <p><img src='img/like.png' alt='like'> " . $row['likes'] . "</p>
                        <p><img src='img/dislike.png' alt='dislike'> " . $row['dislikes'] . "</p>
                    </div>";
                echo "<hr>";
                echo "<a href='user/currentPost.php?post_id=" . $row['post_id'] . "'>comments 0</a>";
                echo "</div>";
            }
        } else {
            echo "<div class='post'>";
            echo "<p>No posts yet</p>";
            echo "</div>";
        }
    }

    //Function to sort posts by date
    function postsByDate() {
        include "db.php";
        $sql = "SELECT * FROM posts JOIN users ON posts.author = users.user_id 
        ORDER BY posts.created_at DESC";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $created_date = $row['created_at'];
            echo "<div class='post'>";
            echo "<p> <a href='user/profile.php?user_id=" . $row['user_id'] . "'><img src='img/user.png' alt='user'></a> " . $row['username'] . " " .date('F j, Y, g:i a', strtotime($created_date)) . "</p>";
            echo "<a class='title' href='user/currentPost.php?post_id=" . $row['post_id'] . "&title=" . $row['title'] . "'><h3>" . $row['title'] . "</h3>";
            echo "<p>" . $row['content'] . "</p></a>";
            echo "<div class='vote'>
                <p><img src='img/like.png' alt='like'> " . $row['likes'] . "</p>
                <p><img src='img/dislike.png' alt='dislike'> " . $row['dislikes'] . "</p>
            </div>";
            echo "<hr>";
            echo "<a href='user/currentPost.php?post_id=" . $row['post_id'] . "'>comments 0</a>";
            echo "</div>";
        }
    }

    //Function to sort post by likes
    function postsByLikes() {
        include "db.php";
        $sql = "SELECT * FROM posts JOIN users ON posts.author = users.user_id 
        ORDER BY posts.likes DESC";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $created_date = $row['created_at'];
            echo "<div class='post'>";
            echo "<p> <a href='user/profile.php?user_id=" . $row['author'] . "'><img src='img/user.png' alt='user'></a> " . $row['username'] . " " .date('F j, Y, g:i a', strtotime($created_date)) . "</p>";
            echo "<a class='title' href='user/currentPost.php?post_id=" . $row['post_id'] . "&title=" . $row['title'] . "'><h3>" . $row['title'] . "</h3>";
            echo "<p>" . $row['content'] . "</p></a>";
            echo "<div class='vote'>
                <p><img src='img/like.png' alt='like'> " . $row['likes'] . "</p>
                <p><img src='img/dislike.png' alt='dislike'> " . $row['dislikes'] . "</p>
            </div>";
            echo "<hr>";
            echo "<a href='user/currentPost.php?post_id=" . $row['post_id'] . "'>comments 0</a>";
            echo "</div>";
        }
    }

    //Function to sort post by comments
    function postsByComments() {
        include "db.php";
        $sql = "SELECT * FROM posts 
        JOIN users ON posts.author = users.user_id 
        JOIN comments ON posts.post_id = comments.post 
        ORDER BY comments.comments DESC";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $created_at = $row['created_at'];
            echo "<div class='post'>";
            echo "<p> <a href='user/profile.php?user_id=" . $row['author'] . "'><img src='img/user.png' alt='user'></a> " . $row['username'] . " " .date('F j, Y, g:i a', strtotime($created_at)). "</p>";
            echo "<a class='title' href='user/currentPost.php?post_id=" . $row['post_id'] . "&title=" . $row['title'] . "''><h3>" . $row['title'] . "</h3>";
            echo "<p>" . $row['content'] . "</p></a>";
            echo "<div class='vote'>
                <img src='img/like.png' alt='like'><p> " . $row['likes'] . "</p>
                <img src='img/dislike.png' alt='dislike'><p> " . $row['dislikes'] . "</p>
            </div>";
            echo "<hr>";
            echo "<a href='user/currentPost.php?post_id=" . $row['post_id'] . "'>comments 0</a>";
            echo "</div>";
        }
    }


    //Function to display comments
    function comments() {
        include "../db.php";
        $postId = $_GET['post_id'];
        $sql = "SELECT * FROM comments 
        JOIN users ON comments.author = users.user_id 
        WHERE comments.post_id = '$postId'";
        $result = $conn->query($sql);
        if($result !== false && $result->num_rows > 0) {
            // Display comments
            while ($row = $result->fetch_assoc()) {
                echo "<div class='comment'>";
                echo "<img src='img/user.png' alt='user'>";
                echo "<h3>" . $row['username'] . "</h3>";
                echo "<p>" . $row['content'] . "</p>";
                echo "<hr>";
                echo "</div>";
            }
        } else {
            echo "<div class='comment'>";
            echo "<p>No comments yet</p>";
            echo "</div>";
        }
    }

    //Function to create post
    function createPost(){
        include "../db.php";
        session_start();
        if(isset($_POST['createPost'])) {
            $sql = "INSERT INTO posts (post_id, title, content, author) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            $stmt->bind_param("ssss", $post_id, $title, $output, $author);
            $post_id = uniqid();
            $title = $_POST['title'];
            $content = $_POST['content'];
            $output = nl2br($content);
            $author = $_SESSION['user_id'];
            if($title == "" || empty($title)) {
                header("Location: ../user/createPost.php?error=The title cannot be empty");
                exit();
            }
            $stmt->execute();
            $stmt->close();

            //Get post id related to the user
            $sql = "SELECT post_id FROM posts WHERE author = '$author' AND title = '$title'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $post_id = $row['post_id'];
            addActivity($author, "created a post a with title " . $title, $post_id, null);
            

            header("Location: ../index.php");
        }
    }

    //Function to edit post
    function editPost($postId) {
        include "../db.php";
        session_start();
        //Get post id
        if(isset($_POST['editPost'])) {
            $sql = "UPDATE posts SET title = ?, content = ? WHERE post_id = ?";
            //Prepare statement
            $stmt = $conn->prepare($sql);
            
            // Get data from form
            $title = $_POST['title'];
            $content = $_POST['content'];
            $author = $_SESSION['user_id'];
            $output = nl2br($content);

            //Bind parameters
            $stmt->bind_param("sss", $title, $output, $postId);

            //Check if title is empty
            if($title == "" || empty($title)) {
                header("Location: ../user/editPost.php?post_id=" . $postId . "&error=The title cannot be empty");
                exit();
            } 
            //Execute statement
            $stmt->execute();

            //Get post id related to the user
            $sql = "SELECT post_id FROM posts WHERE author = '$author' AND title = '$title'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $postId = $row['post_id'];

            
            addActivity($author, "edited a post with title " . $title, $postId, null);
            header("Location: ../index.php?post_id=" . $postId);
        }
    }

    //Function to display current post
    function currentPost($postId, $userId) {
        include "../db.php";
        $result = $conn->query("SELECT * FROM posts 
        JOIN users ON posts.author = users.user_id 
        WHERE posts.post_id = '$postId'");
        $row = $result->fetch_assoc();
        $created_at = $row['created_at'];
        echo "<div class='post'>";
        echo "<p> <a href='user/profile.php?user_id=" . $row['author'] . "'><img src='img/user.png' alt='user'></a> " . $row['username'] . " " .date('F j, Y, g:i a', strtotime($created_at)). "</p>";
        echo "<a class='title' href='user/currentPost.php?post_id=" . $row['post_id'] . "'><h3>" . $row['title'] . "</h3></a>";
        echo "<p>" . $row['content'] . "</p>";
        echo "<div class='vote'>
                    <img src='img/like.png' alt='like'><p> " . $row['likes'] . "</p>
                    <img src='img/dislike.png' alt='dislike'><p> " . $row['dislikes'] . "</p>
            </div>";
            if($userId == $row['author']){
                echo "<div class='post-options'>";
                echo "<a href='deletePost.php?post_id=" . $row['post_id'] . "' class='delete-btn' onclick=\"return confirm('Are you sure you want to delete this post?')\">Delete Post</a>";
                echo "<a href='editPost.php?post_id=" . $row['post_id'] . "'>Edit Post</a>";
                echo "</div>";
            }
        echo "<hr>";
        echo "</div>";
    }

    //Function to delete post
    function deletePost($postId) {
        include "../db.php";
        $sql = "DELETE FROM posts WHERE post_id = '$postId'";
        $conn->query($sql);
        header("Location: ../index.php");
    }


    //Function to display profile
    function profile($userId) {
        include "../db.php";
        $result = $conn->query("SELECT * FROM users WHERE user_id = '$userId'");

            $user = $result->fetch_assoc();
            // Format date
            $date = strtotime($user['joined_at']);
            $date = date('F d, Y', $date);
            $formattedDate = date('F d, Y', strtotime($date));
            // Display profile
            echo "<div>";
            if($user['profile_pic'] == null) {
                echo "<img src='../img/default.jpg' alt='profile'>";
            } else {
                echo "<img src='../img/u/" . $user['profile_pic'] . "' alt='profile'>";
            }
            echo "</div>";
            echo "<div class='profile-info'>
                    <h3>" . $user['username'] . "</h3>
                    <h4>" ."Email: ". $user['email'] . "</h4>
                    <h4>" . "Joined " . $formattedDate . "</h4>
                    <p>" . $user['bio'] . "</p>";
                    if($userId == $_SESSION['user_id']) {
                    echo "<div class='profile-settings'>
                        <a href='user/editProfile.php?user_id=" . $user['user_id'] . "'>Edit Profile</a>
                        <a href='user/changePassword.php?user_id=" . $user['user_id'] . "'>Change Password</a>
                    </div>";
                    } else {
                        // Check if user is friend
                        $sql = "SELECT * FROM friends WHERE user_id = '$userId'";
                        $result = $conn->query($sql);
                        if($result !== false && $result->num_rows > 0) {
                            echo "<div class='profile-settings'>
                                <a href='actions/removeFriend.php?user_id=" . $user['user_id'] . "'>Remove Friend</a>
                            </div>";
                        } else {
                        echo "<div class='profile-settings'>
                            <a href='actions/addFriend.php?user_id=" . $user['user_id'] . "'>Add Friend</a>
                        </div>";
                        }
                    }
            echo "</div>";
    }

    //Function to display activities
    function activities($userId) {
        include "../db.php";
        $sql = "SELECT * FROM users JOIN activities ON users.user_id = activities.user_id WHERE activities.user_id = '$userId'";
        $result = $conn->query($sql);
        echo "<div class='profile-activity'>";
        echo "<h3>Activity</h3>";
        if($result !== false && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='activity-box'>";
                echo "<p>" . $row['activity'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No activity yet</p>";
        }
        echo "</div>";
    }

    function addActivity($userId, $activity, $post_id=null, $comment_id=null) {
        include "../db.php";
        if($post_id != null && $comment_id == null) {
            $sql = "INSERT INTO activities (user_id, activity, post_id) VALUES ('$userId', '$activity', '$post_id')";
            
        }

        if($post_id == null && $comment_id != null) {
            $sql = "INSERT INTO activities (user_id, activity, comment_id) VALUES ('$userId', '$activity', '$comment_id')";
        }

        if($post_id == null && $comment_id == null) {
            $sql = "INSERT INTO activities (user_id, activity) VALUES ('$userId', '$activity')";
        }

        $conn->query($sql);
        if(!$conn){
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
?>