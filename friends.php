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
    <!-- Start Session -->
    <?php
    session_start();
    // Check if the session is set
    if(isset($_SESSION['user_id'])): 
    ?>
    <?php
        // Include queries
        include "actions/queries/post_queries.php";
        include "actions/queries/friend_queries.php";
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
                    $count = getFriendRequestCount($userId);
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
                <h2>Friend Requests</h2>
                <div class="friend-requests-box">
                    <div class="request-box">
                        <?php
                        //Get friend requests
                        $result = getFriendRequests($userId);
                        if($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $profile = $row['profile_pic'];
                                $username = $row['username'];
                                $requester_id = $row['requester_id'];
                                //Check if profile pic exists
                                if(isset($profile) || !is_null($profile)) {
                                    echo "<div class='request'>
                                            <div class='profile-pic'>
                                                <img src='img/u/" . $profile . "' alt='user'>
                                                <p>" . $username . "</p>
                                            </div>
                                            <div class='request-box'>
                                                <h3>" . $username . " has sent you a friend request" . "</h3>
                                                <form action='actions/Friend_act.php?user_id=" . $requester_id . "' method='POST' class='request-btns'>
                                                    <button type='submit' name='accept'>Accept</button>
                                                    <button type='submit' name='decline'>Decline</button>
                                                </form>
                                            </div>
                                        </div>";
                                } else { 
                                    echo "<div class='request'>
                                            <div class='profile-pic'>
                                                <img src='img/default.jpg' alt='user'>
                                                <p>" . $username . "</p>
                                            </div>
                                            <div class='request-box'>
                                                <h3>" . $username . " has sent you a friend request" . "</h3>
                                                <form action='actions/Friend_act.php?user_id=" . $requester_id . "' method='POST' class='request-btns'>
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

            <!-- Friends Area -->
            <div class="friends-container">
                <h2>Friends</h2>
                <div class="friends-box">
                    <?php
                    //Get friends
                    $result = getFriends($userId);
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
    </main>

    <!-- Footer Area -->
    <footer>
        <div class="footer-content">
            <a href="#top">Back to Top</a>
        </div>
    </footer>

    <!-- if not logged in redirect to login page -->
    <?php else: header("Location: auth/login.php") ?>
    <!-- End If Statement -->
    <?php endif; ?>
</body>
</html>