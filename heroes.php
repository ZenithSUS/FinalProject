<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="styles/index.css">
    <title>Heroes</title>
</head>
<body>
    <!-- Start Session -->
    <?php
    session_start();
    // Check if the session is set
    if(isset($_SESSION['user_id'])): 
    ?>
    <!-- Header Area -->
    <nav>
        <!-- Logo -->
        <h2> Greek Myth </h2>
        <!-- Search Bar -->
            <input type="text" placeholder="Search" id="search" class="search">
        <!-- Profile Link -->
        <div class="profile-link">
            <?php
            //Get user id 
            $userId = $_SESSION['user_id'];
            include "db.php";
            // Execute query
            $result = $conn->query("SELECT * FROM users WHERE user_id = '$userId'");
            $row = $result->fetch_assoc();
            //Get profile pic from database
            $profile = $row['profile_pic']; 
            ?>
                <a href="user/profile.php?user_id=<?php echo $userId ?>">
                   <?php
                    //Check if profile pic exists
                   if(isset($profile) || !is_null($profile)) {
                        echo "<img src='img/u/" . $profile . "' alt='user' class='user'>";
                   } else { 
                        echo "<img src='img/default.jpg' alt='user' class='user'>";
                    }?>
            <?php echo $_SESSION['username']; ?></a>
        </div>
    </nav>
    
    <!-- Main Area -->
    <main>
        <div class="main-content">
            <!-- Nav Links -->
            <div class="nav-links"> 
                <a href="index.php">Home</a>
                <a href="friends.php">Friends</a>
                <a href="heroes.php">Heroes</a>
                <a href="actions/logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
            </div>

            <!-- Posts -->
            <div class="posts">
                <div class="createPost-box">
                    <a href="user/profile.php?user_id=<?php echo $userId ?>">
                        <?php 
                        //Check if profile pic exists
                        if(isset($profile) || !is_null($profile)) {
                            echo "<img src='img/u/" . $row['profile_pic'] . "' alt='user'>";
                        } else { 
                            echo "<img src='img/default.jpg' alt='user'>";
                        }?>
                    </a>
                    <a class="createPost" href="user/createPost.php?user_id=<?php echo $userId ?>">Create Post</a>
                </div>
                <?php
                    //Include queries 
                    include "actions/queries.php";
                    //Display posts based on sorting
                    if(isset($_GET['sort'])){
                        $sort = $_GET['sort'];
                        if($sort == 'date') {
                            postsByDate();
                        } 
                        else if($sort == 'likes') {
                            postsByLikes();
                        }
                        else if($sort == 'random') {
                            posts();
                        }
                        else if($sort == 'comments') {
                            postsByComments();
                        }
                    } else { 
                        posts(); 
                    }
                ?>
            </div>

            <!-- Others Area -->
            <div class="other-content">
                <div class="sortPosts">
                    <h2>Sort Posts by</h2>
                    <!-- Sort Posts Buttons -->
                    <div class="sort-btn">
                        <a href="index.php?sort=date">Date</a>
                        <a href="index.php?sort=likes">Likes</a>
                        <a href="index.php?sort=random">Random</a>
                        <a href="index.php?sort=comments">Comments</a>
                    </div>
                </div>
                <!-- Greek Heroes Page Area -->
                <div class="others">
                    <h2>Greek Heroes Page</h2>
                        <div class="heroes">
                            <div class="hero-box">
                                <img src="img/hero.png" alt="hero"> <p> Zeus</p>
                            </div>
                            <div class="hero-box">
                                <img src="img/hero.png" alt="hero"> <p> Poseidon</p>
                            </div>
                            <div class="hero-box">
                                <img src="img/hero.png" alt="hero"> <p> Heracles</p>
                            </div>
                            <div class="hero-box">
                                <img src="img/hero.png" alt="hero"> <p> Perseus</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- if not logged in redirect to login page -->
    <?php else: header("Location: auth/login.php") ?>
    <!-- End If Statement -->
    <?php endif; ?>
</body>
</html>