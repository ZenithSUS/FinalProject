<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="styles/index.css">
    <title>Greek Myth</title>
</head>
<body>
    <!-- Start Session -->
    <?php
    session_start();
    // Include session checker
    include_once "session.php";
    // Check if the session or cookie is set
    if(!isset($_SESSION['user_id']) || !isset($_COOKIE['user_id'])){
        header("Location: auth/login.php");
    } else {
        // Call checkSessionTimeout function
        checkSessionTimeout();
    }
    ?>
    <?php
        // Include queries
        include "queries/post.php";
        include "queries/friend.php";
        // Include db connection
        include "db.php";
    ?>
    <!-- Header Area -->
    <nav>
        <!-- Logo -->
        <h2> Greek Myth </h2>
            <!-- Search Bar -->
            <div class="search-bar">
                <!-- Search Input -->
                 <div class="search-input">
                    <input type="text" placeholder="Search" id="searchInput" data-enter-pressed="false" class="search" oninput="search()">
                    <button class="search-btn" id="search-btn" onclick="search()">Search</button>
                </div>
                <!-- Search Results -->
                <div class="search-results-container">
                    <div id="search-results" class="search-results"></div>
                </div>
            </div>
        <!-- Profile Link -->
        <div class="profile-link">
            <?php
            //Get user id 
            $userId = $_SESSION['user_id'];
            // Execute query
            $result = $conn->query("SELECT * FROM users WHERE user_id = '$userId'") or die($conn->error);
            //Get profile pic from database by using user id and associative array 
            $row = $result->fetch_assoc();
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

    <!-- Navbar for Mobile -->
     <div class="nav-mobile">
        <div class="nav-mobile-links">
            <a href="index.php">Home</a>
            <a href="friends.php" class="friends">Friends
                <!-- Notify when there is friend request -->
                <?php
                //Get friend request count
                $count = getFriendRequestCount($conn, $userId);
                if($count > 0) {
                    echo "<span class='notif'>" . $count . "</span>";
                }
            ?>
            </a>    
            <a href="heroes.php">Heroes</a>
            <a href="actions/logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
        </div>
    </div>
    
    <!-- Main Area -->
    <main>
        <div class="main-content">
            <!-- Nav Links -->
            <div class="nav-links"> 
                <a href="index.php">Home</a>
                <a href="friends.php" class="friends">Friends
                    <!-- Notify when there is friend request -->
                    <?php

                    //Get friend request count
                    $count = getFriendRequestCount($conn, $userId);
                    if($count > 0) {
                        echo "<span class='notif'>" . $count . "</span>";
                    }
                    ?>
                </a>
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
                    //Display posts based on sorting
                    if(isset($_GET['sort'])){
                        $sort = $_GET['sort'];
                        //Check if sort is set on date
                        if($sort == 'date') {
                            postsByDate($conn);
                        }
                        //Check if sort is set on likes 
                        else if($sort == 'likes') {
                            postsByLikes($conn);
                        }
                        //Check if sort is set on random
                        else if($sort == 'random') {
                            posts($conn);
                        }
                        //Check if sort is set on comments
                        else if($sort == 'comments') {
                            postsByComments($conn);
                        }
                        //If sort is not set display posts
                    } else { 
                        posts($conn); 
                    }
                ?>
            </div>

            <!-- Others Content Area -->
            <div class="other-content">
                <div class="other-scroll" id="other-scroll">
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
                        <!-- Title -->
                        <h2>Greek Heroes Page</h2>
                            <!-- Heroes Container -->
                            <div class="heroes">
                                <!-- Hero Boxes -->
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

        </div>
    </main>

    <!-- Footer Area -->
    <footer>
        <div class="footer-content">
            <a href="#top">Back to Top</a>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="scripts/search.js"></script>

   
</body>
</html>