<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/currentPost.css">
    <link rel="stylesheet" href="../styles/comment.css">
    <!-- Title -->
    <title>
        <?php 
        //Check if title is set
        if(isset($_GET['title'])) : echo $_GET['title'] ?> 
        <?php else : echo 'Post' ?> <?php endif; 'Post' ?>
    </title>
</head>
<body>
    <!-- Start Session -->
    <?php
    session_start();
    // Check if the session is set
    if(isset($_SESSION['user_id'])): 
    ?>
    <nav>
        <!-- Logo -->
        <h2> Greek Myth </h2>
            <!-- Search Bar -->
            <input type="text" placeholder="Search" id="search" class="search">
        <!-- Profile Link -->
        <div class="profile-link">
        <?php 
            //Get user id in session
            $userId = $_SESSION['user_id'];
            include "../db.php";
            // Execute query
            $result = $conn->query("SELECT * FROM users WHERE user_id = '$userId'");
            //Get profile pic from database by using user id and associative array
            $row = $result->fetch_assoc(); 
            ?>
                <a href="profile.php?user_id=<?php echo $userId ?>">
                   <?php 
                    //Check if profile pic exists
                    if(isset($row['profile_pic'])) {
                       echo "<img src='../img/u/" . $row['profile_pic'] . "' alt='user' class='user'>";
                    // Display default image if no profile pic
                   } else { 
                    echo "<img src='../img/default.jpg' alt='user' class='user'>";
                    }?>
            <?php echo $_SESSION['username']; ?></a>
        </div>
    </nav>
    
    <!-- Main Area -->
    <main>
        <div class="main-content">
            <!-- Nav Links -->
            <div class="nav-links"> 
                <a href="../index.php">Home</a>
                <a href="friends.php">Friends</a>
                <a href="../heroes.php">Heroes</a>
                <a href="../actions/logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
            </div>

        <!-- Current Post Area -->
        <div class="posts current-posts">
            <!-- Display Current Post -->
            <?php
                 //Include queries
                 include "../actions/queries.php";

                 //Get post id and user id from url or using GET method
                 $postId = $_GET['post_id'];
                 $userId = $_SESSION['user_id'];
 
                 //Call currentPost function
                 currentPost($postId, $userId);
            ?>

            <!-- Comment Form Container -->
            <div class='comment-form'>
                <!-- Heading or Title -->
                <h2 id='commentTitle'>What are your thoughts</h2>
                <!-- Comment Form -->
                <form action='../actions/comment_act.php?post_id=<?php echo $postId ?>' method='post'>
                <!-- Comment Field -->
                <textarea name='comment' id='comment' cols='30' rows='10'></textarea>
                <!-- Submit Button -->
                <button type='submit' name='commentForm' id='commentBtn' onclick="disableCommentBtn()">Comment</button>
                </form>
            </div>

            <?php
                //Call comments function  
                comments();
            ?>
                
            
        </div>

        <!-- Others Content Area -->
            <div class="other-content">
                <!-- Others Container -->
                <div class="others">
                    <!-- Heading or Title -->
                    <h2>Greek Heroes Page</h2>
                    <!-- Heroes Container -->
                        <div class="heroes">
                            <!-- Hero Boxes -->
                            <div class="hero-box">
                                <img src="../img/hero.png" alt="hero"> <p> Zeus</p>
                            </div>
                            <div class="hero-box">
                                <img src="../img/hero.png" alt="hero"> <p> Poseidon</p>
                            </div>
                            <div class="hero-box">
                                <img src="../img/hero.png" alt="hero"> <p> Heracles</p>
                            </div>
                            <div class="hero-box">
                                <img src="../img/hero.png" alt="hero"> <p> Perseus</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="../scripts/disableBtns.js"></script>

    <!-- If not logged in redirect to login page -->
    <?php else: header("Location: ../auth/login.php") ?>
    <!-- End If Statement -->
    <?php endif; ?>
</body>
</html>