<?php
    // Start Session
    session_start();
    // Include session checker
    include_once "session.php";
    // Check if the session is set
    if(!isset($_SESSION['user_id']) || !isset($_COOKIE['user_id'])){
        // Unset sessions
        session_unset();
        //Destroy session
        session_destroy();
        echo "<script>window.location.href = 'auth/login.php'</script>";
    } else {
        checkSessionTimeout();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/friends.css">
    <title>Friends</title>
</head>
<body>
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
        <a class="logo" href="index.php"><img src="img/misc/logo_transparent.png" alt="logo"></a>
        <!-- Search Bar -->
        <div class="search-bar">
            <!-- Search Input -->
            <div class="search-input">
                <input type="text" placeholder="Search Users" id="searchInput" data-enter-pressed="false" class="search" oninput="search()">
                <button class="search-button" id="searchButton">Search</button>
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
            <?php 
                //Check if user is set
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
                    <button class="search-button-mobile" id="searchButton-mobile">Search</button>
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
        <div class="friend-content">
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

            <!-- Posts / Friend Requests Area -->
            <div class="friend-requests">
                <!-- Friend Requests -->
                <h2>Friend Requests <?php if($count > 0) echo $count; ?></h2>
                <div class="friend-requests-box">
                    <button class="request-view-btn">View Requests</button>
                    <div class="request-box hidden">
                        <?php
                        //Get friend requests
                        $result = getFriendRequests($conn, $userId);
                        if($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $profile = $row['profile_pic'];
                                $username = $row['username'];
                                $requester_id = $row['requester_id'];
                                //Check if profile pic exists
                                if(isset($profile) || !is_null($profile)) {
                                    echo "<div class='request'>
                                            <div class='profile-pic'>
                                                <a href='user/profile.php?user_id=" . $requester_id . "'><img src='img/u/" . $profile . "' alt='user'>
                                                <p>" . $username . "</p></a>
                                            </div>
                                            <div class='request-box'>
                                                <h3>" . $username . " has sent you a friend request" . "</h3>
                                                <form action='actions/friend_act.php?user_id=" . $requester_id . "' method='POST' class='request-btns'>
                                                    <button type='submit' name='accept'>Accept</button>
                                                    <button type='submit' name='decline'>Decline</button>
                                                </form>
                                            </div>
                                        </div>";
                                } else { 
                                    echo "<div class='request'>
                                            <div class='profile-pic'>
                                                <a href='user/profile.php?user_id=" . $requester_id . "'><img src='img/default.jpg' alt='user'>
                                                <p>" . $username . "</p></a>
                                            </div>
                                            <div class='request-box'>
                                                <h3>" . $username . " has sent you a friend request" . "</h3>
                                                <form action='actions/friend_act.php?user_id=" . $requester_id . "' method='POST' class='request-btns'>
                                                    <button type='submit' name='accept'>Accept</button>
                                                    <button type='submit' name='decline'>Decline</button>
                                                </form>
                                            </div>
                                        </div>";
                                }
                            }
                        } else {
                            echo "<p>No friend requests</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Friends in Mobile Mode -->
            <div class="friends-mobile">
                <h2>Friends</h2>
                <button class="friends-view-btn">View Friends</button>
                <div class="friends-mobile-box hidden">
                    <?php
                    //Get friends
                    $result = getFriends($conn, $userId);
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $profile = $row['profile_pic'];
                            $username = $row['username'];
                            //Check if profile pic exists
                            if(isset($profile) || !is_null($profile)) {
                                echo "<div class='friend-details'>
                                        <div class='profile-pic'>
                                            <a href='user/profile.php?user_id=" . $row['user_id'] . "'><img src='img/u/" . $profile . "' alt='user'></a>
                                            <p>" . $username . "</p>
                                        </div>
                                    </div>";
                            } else { 
                                echo "<div class='friend-details'>
                                        <div class='profile-pic'>
                                            <a href='user/profile.php?user_id=" . $row['user_id'] . "'><img src='img/default.jpg' alt='user'></a>
                                            <p>" . $username . "</p>
                                        </div>
                                    </div>";
                            }
                        }
                    } else {
                        echo "<p>No friends</p>";
                    }
                    ?>
                </div>
            </div>


            <!-- Friends Area -->
            <div class="friends-container">
                <h2>Friends</h2>
                <div class="friends-scroll">
                    <div class="friends-box">
                        <?php
                        //Get friends
                        $result = getFriends($conn, $userId);
                        if($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $profile = $row['profile_pic'];
                                $username = $row['username'];
                                //Check if profile pic exists
                                if(isset($profile) || !is_null($profile)) {
                                    echo "<div class='friend-details'>
                                            <div class='profile-pic'>
                                                <a href='user/profile.php?user_id=" . $row['user_id'] . "'><img src='img/u/" . $profile . "' alt='user'></a>
                                                <p>" . $username . "</p>
                                            </div>
                                        </div>";
                                } else { 
                                    echo "<div class='friend-details'>
                                            <div class='profile-pic'>
                                                <a href='user/profile.php?user_id=" . $row['user_id'] . "'><img src='img/default.jpg' alt='user'></a>
                                                <p>" . $username . "</p>
                                            </div>
                                        </div>";
                                }
                            }
                        } else {
                            echo "<p>No friends</p>";
                        }
                    ?>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Scripts -->
    <script src="scripts/search.js"></script>
    <script src="scripts/burgerMenu.js"></script>
    <script src="scripts/showFriend.js"></script>

</body>
</html>