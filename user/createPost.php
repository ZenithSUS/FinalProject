<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/createPost.css">
    <!-- Title -->
    <title>Create Post</title>
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
        checkSessionTimeout();
    }
    ?>
    <?php
        //Include queries
        include "../queries/post.php";
        include "../queries/friend.php";
        //Include db connection
        include "../db.php";
    ?>
    <nav> 
        <!-- Logo -->
        <h2> Greek Myth </h2>
            <!-- Search Bar -->
            <div class="search-bar">
                <!-- Search Input -->
                 <div class="search-input">
                    <input type="text" placeholder="Search" id="searchInput" data-enter-pressed="false" class="search" oninput="searchUser()">
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
            $userId = $_SESSION['user_id'];
            $result = $conn->query("SELECT * FROM users WHERE user_id = '$userId'");
            $row = $result->fetch_assoc(); 
            ?>
                <a href="profile.php?user_id=<?php echo $userId ?>">
                   <?php 
                    //Check if profile pic exists
                    if(isset($row['profile_pic'])) {
                       echo "<img src='../img/u/" . $row['profile_pic'] . "' alt='user' class='user'>";
                   } else { 
                    echo "<img src='../img/default.jpg' alt='user' class='user'>";
                    }?>
            <?php echo $_SESSION['username']; ?></a>
        </div>
    </nav>

    <!-- Main Area -->
    <main>
        <div class="create-content">
            <!-- Nav Links -->
            <div class="nav-links"> 
                <a href="../index.php">Home</a>
                <a href="friends.php" class="friends">Friends
                    <!-- Notify when there is friend request -->
                    <?php
                    //Get friend request count
                    $count = getFriendRequestCountUser($conn, $userId);
                    if($count > 0) {
                        echo "<span class='notif'>" . $count . "</span>";
                    }
                    ?>
                </a>
                <a href="../heroes.php">Heroes</a>
                <a href="../actions/logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
            </div>

            <!-- Create Post Area -->
            <div class="createPost">
                <!-- Create Post Container -->
                <div class="createForm-container">
                    <!-- Heading or Title -->
                    <h2 id="postTitle">Create Post</h2>
                    <!-- Create Post Form -->
                    <form action="../actions/createPost_act.php" method="POST">
                        <!-- Title Field -->
                        <div class="form-group"> 
                            <label for="title">Title</label>
                                <input type="text" name="title" placeholder="Title">
                            <!-- Error Message -->
                            <?php if(isset($_GET['error'])) { echo "<p class='error'>" . $_GET['error'] . "</p>"; } ?>
                        </div>
                        <!-- Content Field -->
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" cols="30" rows="10" placeholder="Write something..."></textarea>
                        </div>
                        <!-- Submit Button -->
                        <div class="createPost-btn">
                            <button type="submit" name="createPost" id="postBtn">Post</button>
                            <a href="../index.php" id="backBtn">Go back</a>
                        </div>
                    </form>
                </div>
            </div>

             <!-- Others Content Area -->
             <div class="other-content">
                <div class="other-scroll" id="other-scroll">
                    <!-- Greek Heroes Page Area -->
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
                </div>
            </div>
        </div>
    </main>

    <!--Scripts-->
    <script src="../scripts/search.js"></script>
</body>
</html>