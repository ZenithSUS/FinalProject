<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="styles/index.css">
    <title>Greek Myth</title>
</head>
<body>
    <!-- Start Session -->
    <?php
    session_start();
    // Check if the session is set
    if(isset($_SESSION['user_id'])): 
    ?>
    <nav>
        <div>
            <h2> Greek Myth </h2>
        </div>
        <div> 
            <input type="text" placeholder="Search" id="search" class="search">
        </div>
        <div class="profile-link">
            <img src="img/default.jpg" alt="user" class="user">
            <?php echo "<strong style='font-size: 20px;'>".$_SESSION['username']."</strong>"; ?>
        </div>
    </nav>

    <main>
        <div class="main-content">
            <div class="nav-links"> 
                <a href="index.php">Home</a>
                <a href="friends.php">Friends</a>
                <a href="actions/logout.php">Logout</a>
            </div>
            <div class="posts">
                <div class="createPost-box">
                    <?php $userId = $_SESSION['user_id']; ?>
                    <a href="user/profile.php?user_id=<?php echo $userId ?>"><img src="img/default.jpg" alt="user"></a>
                    <a class="createPost" href="user/createPost.php">Create Post<a>
                </div>
                <?php 
                    include "actions/queries.php"; 
                    posts();
                ?>
            </div>
            <div class="discussion">
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
    </main>

    
    <?php else: header("Location: auth/login.php") ?>
    <?php endif; ?>
</body>
</html>