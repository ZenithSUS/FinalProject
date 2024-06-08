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
            //Get user id
            $userId = $_SESSION['user_id'];
            include "../db.php";
            // Execute query
            $result = $conn->query("SELECT * FROM users WHERE user_id = '$userId'");
            // Fetch result
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
    
    <!-- Profile Page -->
    <main>
        <div class="main-content">
            <!-- Nav Links -->
            <div class="nav-links"> 
                <a href="../index.php">Home</a>
                <a href="../friends.php">Friends</a>
                <a href="../heroes.php">Heroes</a>
                <a href="../actions/logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
            </div>

            <!-- Post Area -->
            <div class="posts">
                <!-- Profile Container -->
                <div class="profile-container">
                    <div class="profile-box">
                        <?php
                            // include queries
                            include "../actions/queries.php";

                            // Get user id from url
                            $userId = $_GET['user_id'];
                            // Display profile or call profile function
                            profile($userId);
                        ?>
                    </div>
                    <div class="profile-box">
                        <!-- Display activities or call activities function -->
                        <?php activities($userId); ?>
                    </div>
                </div>
            </div>

            <!-- Others Area -->
            <div class="others">
                <!-- Title -->
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
    </main>

    <!-- If user is not logged in -->
    <?php else: header("Location: ../auth/login.php") ?>
    <!-- End If Statement -->
    <?php endif; ?>
</body>
</html>