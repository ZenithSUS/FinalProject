<?php
    //Function to login
    function login($username, $password) {
        //Include db connection
        include "../db.php";
        //Write query and prepare statement
        $sql = "SELECT * FROM users WHERE username=? OR email=?";
        $stmt = $conn->prepare($sql);
        //Check if query is prepared
        if(!$stmt->prepare($sql)) {
            header("Location: ../auth/login.php?error=sqlerror");
            exit();
        //Else bind parameters and execute
        } else {
            //Bind parameters
            $stmt->bind_param("ss", $username, $username);
            //Execute query
            $stmt->execute();
            //Get result
            $result = $stmt->get_result();
            //Check if user exists
            if($result->num_rows === 0) {
                header("Location: ../auth/login.php?error=No user exists in the database");
                exit();
            }
            //Else check if password is correct
            else {
                $row = $result->fetch_assoc();
                if(password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['username'];
                    header("Location: ../index.php");
                //Else password is incorrect
                } else {
                    //Close statement
                    $stmt->close();
                    $conn->close();
                    header("Location: ../auth/login.php?error=Incorrect username or password");
                }
                //Exit if password is incorrect
                exit();
            }
        }
    }

    //Function to register
    function register($username, $email, $password) {
        //Include db connection
        include "../db.php";
        //Write query and prepare statement
        $sql = "INSERT INTO users (user_id, username, email, password) VALUES (?, ?, ?, ?)";
        //Prepare statement
        $stmt = $conn->prepare($sql);
        //Check if query is prepared
        if(!$stmt->prepare($sql)) {
            //Close statement
            header("Location: ../auth/register.php?error=sqlerror");
            exit();
        } else {
            //Generate user id
            $user_id = mysqli_real_escape_string($conn, uniqid());
            //Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            //Bind parameters and execute query
            $stmt->bind_param("ssss", $user_id, $username, $email, $hashed_password);
            $stmt->execute();

            //Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            //Close statement
            $conn->close();
            $stmt->close();
            echo "<script>alert('Registered successfully!')</script>";
            echo "<script>window.location.href = '../auth/uploadProfile.php';</script>";
        }
    }

    //Function to display posts in random order
    function posts() {  
        //Include db connection  
        include "db.php";
        //Write query and join tables
        $sql = "SELECT * FROM posts JOIN users ON posts.author = users.user_id
        ORDER BY RAND()";
        //Execute query
        $result = $conn->query($sql);
        //Display posts in random order
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
                echo $row['username'] . " " . date('F j, Y, g:i a', strtotime($created_date)) . "</p>";
                //Display title and content
                echo "<a class='title' href='user/currentPost.php?post_id=" . $row['post_id'] . "&title=" . $row['title'] . "'><h3>" . $row['title'] . "</h3>";
                echo "<p>" . $row['content'] . "</p></a>";
                //Display likes and dislikes
                echo "<div class='vote'>
                        <p><img src='img/like.png' alt='like'> " . $row['likes'] . "</p>
                        <p><img src='img/dislike.png' alt='dislike'> " . $row['dislikes'] . "</p>
                    </div>";
                //Display comments
                echo "<hr>";
                echo "<a href='user/currentPost.php?post_id=" . $row['post_id'] . "'>comments 0</a>";
                echo "</div>";
            }
        //Else display no posts yet
        } else {
            echo "<div class='post'>";
            echo "<p>No posts yet</p>";
            echo "</div>";
        }
        //Close connection
        $conn->close();
    }

    //Function to sort posts by date
    function postsByDate() {
        //Include db connection
        include "db.php";
        //Write query and join tables
        $sql = "SELECT * FROM posts JOIN users ON posts.author = users.user_id 
        ORDER BY posts.created_at DESC";
        //Execute query
        $result = $conn->query($sql);
        //Display posts in date order
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
            echo $row['username'] . " " . date('F j, Y, g:i a', strtotime($created_date)) . "</p>";
            //Display title and content
            echo "<a class='title' href='user/currentPost.php?post_id=" . $row['post_id'] . "&title=" . $row['title'] . "'><h3>" . $row['title'] . "</h3>";
            echo "<p>" . $row['content'] . "</p></a>";
            //Display likes and dislikes
            echo "<div class='vote'>
                <p><img src='img/like.png' alt='like'> " . $row['likes'] . "</p>
                <p><img src='img/dislike.png' alt='dislike'> " . $row['dislikes'] . "</p>
            </div>";
            //Display comments
            echo "<hr>";
            echo "<a href='user/currentPost.php?post_id=" . $row['post_id'] . "'>comments 0</a>";
            echo "</div>";
        }
    }

    //Function to sort post by likes
    function postsByLikes() {
        //Include db connection
        include "db.php";
        //Write query and join tables
        $sql = "SELECT * FROM posts JOIN users ON posts.author = users.user_id 
        ORDER BY posts.likes DESC";
        //Execute query
        $result = $conn->query($sql);
        //Check if posts exist
        if($result !== false && $result->num_rows > 0) {
            //Display posts in likes order
            while ($row = $result->fetch_assoc()) {
                //Get post date and time
                $created_date = $row['created_at'];
                //Posts Containers
                echo "<div class='post'>";
                //Display username and date
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
                echo $row['username'] . " " . date('F j, Y, g:i a', strtotime($created_date)) . "</p>";
                //Display title and content
                echo "<a class='title' href='user/currentPost.php?post_id=" . $row['post_id'] . "&title=" . $row['title'] . "'><h3>" . $row['title'] . "</h3>";
                echo "<p>" . $row['content'] . "</p></a>";
                //Display likes and dislikes
                echo "<div class='vote'>
                        <p><img src='img/like.png' alt='like'> " . $row['likes'] . "</p>
                        <p><img src='img/dislike.png' alt='dislike'> " . $row['dislikes'] . "</p>
                    </div>";
                //Display comments
                echo "<hr>";
                echo "<a href='user/currentPost.php?post_id=" . $row['post_id'] . "'>comments 0</a>";
                echo "</div>";
            }
        } else {
            echo "<div class='post'><p>No posts Found</p></div>";
        }
    }

    //Function to sort post by comments
    function postsByComments() {
        include "db.php";
        $sql = "SELECT * FROM posts 
        JOIN users ON posts.author = users.user_id 
        JOIN comments ON posts.post_id = comments.post 
        ORDER BY comments.comments DESC";
        //Execute query
        $result = $conn->query($sql);
        if($result !== false && $result->num_rows > 0) {
            //Display posts in comments order
            while ($row = $result->fetch_assoc()) {
                //Get post date and time
                $created_date = $row['created_at'];
                //Posts Containers
                echo "<div class='post'>";
                //Display username and date
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
                echo $row['username'] . " " . date('F j, Y, g:i a', strtotime($created_date)) . "</p>";
                //Display title and content
                echo "<a class='title' href='user/currentPost.php?post_id=" . $row['post_id'] . "&title=" . $row['title'] . "'><h3>" . $row['title'] . "</h3>";
                echo "<p>" . $row['content'] . "</p></a>";
                //Display likes and dislikes
                echo "<div class='vote'>
                        <p><img src='img/like.png' alt='like'> " . $row['likes'] . "</p>
                        <p><img src='img/dislike.png' alt='dislike'> " . $row['dislikes'] . "</p>
                    </div>";
                //Display comments
                echo "<hr>";
                echo "<a href='user/currentPost.php?post_id=" . $row['post_id'] . "'>comments" . $row['comments'] . "</a>";
                echo "</div>";
            }
        } else {
            echo "<div class='post'><p>No posts Found</p></div>";
        }
        //Close connection
        $conn->close();
    }


    //Function to display comments
    function comments() {
        //Include queries
        include "../db.php";
        //Get post id from url or using GET method
        $postId = $_GET['post_id'];
        //Write query and join tables to display comments
        $sql = "SELECT * FROM comments 
        JOIN users ON comments.author = users.user_id 
        WHERE comments.post_id = '$postId'";
        //Execute query
        $result = $conn->query($sql);
        //Check if comments exist
        if($result !== false && $result->num_rows > 0) {
            // Display comments
            while ($row = $result->fetch_assoc()) {
                //Display comments
                echo "<div class='comment'>
                        <img src='img/user.png' alt='user'>
                            <h3>" . $row['username'] . "</h3>
                            <p> " . $row['content'] . "</p>
                        <hr>
                    </div>";
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

    //Function to create post
    function createPost(){
        //Include queries
        include "../db.php";
        //Initialize session
        session_start();
        //Check if form is submitted
        if(isset($_POST['createPost'])) {
            //Write query
            $sql = "INSERT INTO posts (post_id, title, content, author) VALUES (?, ?, ?, ?)";
            //Prepare statement
            $stmt = $conn->prepare($sql);

            //Bind parameters
            $stmt->bind_param("ssss", $post_id, $title, $output, $author);
            //Set parameters
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
            $output = strip_tags($content);

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
            //Execute query
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            //Get post id related to the user
            $postId = $row['post_id'];

            //Add activity or call function addActivity
            addActivity($author, "edited a post with title " . $title, $postId, null);
            header("Location: ../index.php?post_id=" . $postId);
        }
    }

    //Function to display current post
    function currentPost($postId, $userId) {
        //Include queries
        include "../db.php";
        //Writequery and join tables to display current posts
        $sql = "SELECT * FROM posts 
        JOIN users ON posts.author = users.user_id 
        WHERE posts.post_id = '$postId'";
        //Execute query
        $result = $conn->query($sql);
        //Get post data from query using fetch_assoc
        $row = $result->fetch_assoc();
        //Get post date and time from created_at
        $created_at = $row['created_at'];
        //Display post
        echo "<div class='post'>";
        //Display username and date of post
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
        echo $row['username'] . " " . date('F j, Y, g:i a', strtotime($created_at)) . "</p>";
        
        //Display post title and content
        echo "<a class='title' href='user/currentPost.php?post_id=" . $row['post_id'] . "'><h3>" . $row['title'] . "</h3></a>";
        echo "<p>" . $row['content'] . "</p>";
        //Display likes and dislikes
        echo "<div class='vote'>
                    <img src='img/like.png' alt='like'><p> " . $row['likes'] . "</p>
                    <img src='img/dislike.png' alt='dislike'><p> " . $row['dislikes'] . "</p>
            </div>";
            //Display options to edit or delete post
            if($userId == $row['author']){
                echo "<div class='post-options'>";
                echo "<a href='deletePost.php?post_id=" . $row['post_id'] . "' class='delete-btn' onclick=\"return confirm('Are you sure you want to delete this post?')\">Delete Post</a>";
                echo "<a href='editPost.php?post_id=" . $row['post_id'] . "'>Edit Post</a>";
                echo "</div>";
            }
        echo "<hr>";
        echo "</div>";
        //Close connection
        $conn->close();
    }

    //Function to delete post
    function deletePost($postId) {
        //Include queries
        include "../db.php";
        //Write sql query to delete table
        $sql = "DELETE FROM posts WHERE post_id = '$postId'";
        //Execute query
        $conn->query($sql);
        //Redirect to index
        header("Location: ../index.php");

    }


    //Function to display profile
    function profile($userId) {
        //Include database
        include "../db.php";
        //Write and Execute Query
        $result = $conn->query("SELECT * FROM users WHERE user_id = '$userId'");
            //Get user data using fetch_assoc or fetch associative arrays
            $user = $result->fetch_assoc();
            // Format date
            $date = strtotime($user['joined_at']);
            $date = date('F d, Y', $date);
            $formattedDate = date('F d, Y', strtotime($date));
            // Display profile
            echo "<div>";
            //If profile picture exists
            if($user['profile_pic'] == null) {
                echo "<img src='../img/default.jpg' alt='profile'>";
            } else {
                echo "<img src='../img/u/" . $user['profile_pic'] . "' alt='profile'>";
            }
            echo "</div>";
            //Display Profile Info
            echo "<div class='profile-info'>
                    <h3>" . $user['username'] . "</h3>
                    <h4>" ."Email: ". $user['email'] . "</h4>
                    <h4>" . "Joined " . $formattedDate . "</h4>";
                    //Checks if user set a Bio
                    if(is_null($user['bio'])) {
                        echo "<p>No bio</p>";
                    } else {
                        echo "<p>" . $user['bio'] . "</p>";
                    }
                    //Display profile settings if user is the same as the logged in user
                    if($userId == $_SESSION['user_id']) {
                    // Display options to edit or delete profile
                    echo "<div class='profile-settings'>
                        <a href='user/editProfile.php?user_id=" . $user['user_id'] . "'>Edit Profile</a>
                        <a href='user/changePassword.php?user_id=" . $user['user_id'] . "'>Change Password</a>
                    </div>";
                    } else {
                        // Check if user is friend
                        $sql = "SELECT * FROM friends WHERE user_id = '$userId'";
                        $result = $conn->query($sql);
                        // Display options to add or remove friend
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
            //Close connection
            $conn->close();
    }

    //Function to display activities
    function activities($userId) {
        //Include database
        include "../db.php";
        //Write query and join tables on user_id
        $sql = "SELECT * FROM users JOIN activities ON users.user_id = activities.user_id 
        WHERE activities.user_id = '$userId' ORDER BY timestamp DESC";
        //Execute query
        $result = $conn->query($sql);
        //Display activities
        echo "<div class='profile-activity'>";
        echo "<h3>Activity</h3>";
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
        //Close connection
        $conn->close();
    }

    //Function to add activity
    function addActivity($userId, $activity, $post_id=null, $comment_id=null) {
        //Include database
        include "../db.php";
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
        //Close connection
        $conn->close();
    }
?>