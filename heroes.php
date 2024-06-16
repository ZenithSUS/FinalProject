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
    // Include session checker
    include_once "session.php";
    // Check if the session is set
    if(!isset($_SESSION['user_id']) || !isset($_COOKIE['user_id'])){
        header("Location: auth/login.php");
    } else {
        checkSessionTimeout();
    }
    ?>
    <?php
        // include queries
        include "queries/post.php";
        include "queries/friend.php";
        // include db connection
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
                <button class="search-btn">Search</button>
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
            
            <?php 
                //Check if username is set
                if(isset($_SESSION['username'])) {
                    echo $_SESSION['username'];
                } 
            ?></a>
        </div>

        <!-- Burger Menu Button -->
        <div class="burger-menu-btn">
            <button class="burger-menu-icon">Menu</button>
        </div>

        <!-- Enable Burger Menu on Mobile -->
        <div class="burger-menu hidden">
            <div class="profile-link-mobile">
                <a href="user/profile.php?user_id=<?php echo $userId ?>">
                   <?php
                        //Check if profile pic exists
                        if(isset($profile) || !is_null($profile)) {
                            echo "<img src='img/u/" . $profile . "' alt='user' class='user'>";
                        } else { 
                            echo "<img src='img/default.jpg' alt='user' class='user'>";
                        }?>
                <?php echo $_SESSION['username']; ?></a>
                </a>
            </div>
            <!-- Search Bar -->
            <div class="search-bar-mobile">
                <!-- Search Input -->
                 <div class="search-input-mobile">
                    <input type="text" placeholder="Search" id="searchInput-mobile" data-enter-pressed="false" class="search-mobile" oninput="MobileSearch()">
                    <button class="search-mobile-btn" id="search-btn" onclick="MobileSearch()">Search</button>
                </div>
                <!-- Search Results -->
                <div class="search-results-mobile-container">
                    <div id="search-results-mobile" class="search-results-mobile"></div>
                </div>
            </div>
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
            <div class="greeks">
               
            </div>

            <!-- Others Content Area -->
            <div class="other-content">
                <div class="other-scroll" id="other-scroll">
                    
                </div>
            </div>


        </div>
    </main>

    <!-- Script -->
    <script src="scripts/search.js"></script>
    <script src="scripts/burgerMenu.js"></script>

</body>
</html>