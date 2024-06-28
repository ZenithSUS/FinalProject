<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/profile.css">
    <!-- Title -->
    <title>Profile</title>
</head>
<body>
    <!-- Check if the user id is set -->
    <?php
    if(isset($_GET['user_id']) && $_GET['user_id'] != "null" && !empty($_GET['user_id'])) {
        $userId = $_GET['user_id'];
    } else {
        header("Location: ../index.php");
    }
    ?>
    <!-- Start Session -->
    <?php
    session_start();
    // Include session checker
    include_once "session.php";
    // Check if the session is set
    if(!isset($_SESSION['user_id']) || !isset($_COOKIE['user_id'])){
        // Unset sessions
        session_unset();
        //Destroy session
        session_destroy();
        header("Location: ../auth/login.php");
    } else {
        checkSessionTimeout();
    }
    ?>
    <?php
        // include queries
        include "../queries/post.php";
        include "../queries/profile.php";
        include "../queries/friend.php";
        include "../queries/activity.php";
        include "../queries/greek.php";
        // include db connection
        include "../db.php";
    ?>
    <nav>
        <!-- Logo -->
        <a class="logo" href="../index.php"><img src="../img/misc/logo_transparent.png" alt="logo"></a>
            <!-- Search Bar -->
            <div class="search-bar">
                <!-- Search Input -->
                 <div class="search-input">
                    <input type="text" placeholder="Search Users" id="searchInput" data-enter-pressed="false" class="search" oninput="searchUser()">
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
            // Get Rows
            $row = $result->fetch_assoc(); 
            //Get profile pic
            $profile = $row['profile_pic'];
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

        <!-- Burger Menu Button -->
        <div class="burger-menu-btn">
            <button class="burger-menu-icon">Menu</button>
        </div>

        <!-- Enable Burger Menu on Mobile -->
        <div class="burger-menu hidden">
            <div class="profile-link-mobile">
                <a href="profile.php?user_id=<?php echo $userId ?>">
                   <?php
                        //Check if profile pic exists
                        if(isset($profile) || !is_null($profile)) {
                            echo "<img src='../img/u/" . $profile . "' alt='user' class='user'>";
                        } else { 
                            echo "<img src='../img/default.jpg' alt='user' class='user'>";
                        }?>
                <?php echo $_SESSION['username']; ?></a>
                </a>
            </div>
            <!-- Search Bar -->
            <div class="search-bar-mobile">
                <!-- Search Input -->
                 <div class="search-input-mobile">
                    <input type="text" placeholder="Search" id="searchInput-mobile" data-enter-pressed="false" class="search-mobile" oninput="MobileSearchUser()">
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
            <a href="../index.php">Home</a>
            <a href="../friends.php" class="friends">Friends
                <!-- Notify when there is friend request -->
                <?php
                //Get friend request count
                $count = getFriendRequestCount($conn, $userId);
                if($count > 0) {
                    echo "<span class='notif'>" . $count . "</span>";
                }
            ?>
            </a>    
            <a href="../heroes.php">Heroes</a>
            <a href="../actions/logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
        </div>
    </div>
    
    <!-- Profile Page -->
    <main>
        <div class="main-content">
            <!-- Nav Links -->
            <div class="nav-links"> 
                <a href="../index.php">Home</a>
                <a href="../friends.php" class="friends">Friends
                    <!-- Notify when there is friend request -->
                    <?php
                    //Get friend request count
                    $sql = "SELECT * FROM friend_requests WHERE requestee_id = ? AND status = 'pending'";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $userId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $count = $result->num_rows;
                    if($count > 0) {
                        echo "<span class='notif'>" . $count . "</span>";
                    }
                    ?>
                </a>
                <a href="../heroes.php">Heroes</a>
                <a href="../actions/logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
            </div>

            <!-- Profile Area -->
            <div class="posts">
                <!-- Profile Container -->
                <div class="profile-container">
                    <div class="profile-box">
                        <?php
                            // Get user id from url
                            $userId = $_GET['user_id'];
                            // Display profile or call profile function
                            profile($conn, $userId);
                        ?>
                    </div>
                    <div class="profile-box">
                        <!-- Display activities or call activities function -->
                        <?php activities($conn, $userId); ?>
                    </div>
                </div>
            </div>

            <!-- User All Posts Area -->
            <div class="posts">
                <div class="userPosts-title">User Posts</div>
                <?php Userposts($conn, $userId); ?>
            </div>


            <!-- Others Content Area -->
            <div class="other-content">
                <div class="other-scroll" id="other-scroll">
                    <!-- Greek Heroes Page Area -->
                    <div class="others">
                        <!-- Title -->
                        <h2>Greek Pages</h2>
                            <!-- Heroes Container -->
                            <div class="heroes">
                            <?php 
                                //Get heroes
                                $heroes = getGreeksUser($conn, $userId);
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
    
    <!-- Scripts -->
    <script src="../scripts/search.js"></script>
    <script src="../scripts/burgerMenu.js"></script>
    <script src="../scripts/copyClipboard.js"></script>

</body>
</html>