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
        <h2> Greek Myth </h2>
            <input type="text" placeholder="Search" id="search" class="search">
        <div class="profile-link">
            <?php 
            $userId = $_SESSION['user_id'];
            include "db.php";
            $result = $conn->query("SELECT * FROM users WHERE user_id = '$userId'");
            $row = $result->fetch_assoc(); 
            ?>
                <a href="user/profile.php?user_id=<?php echo $userId ?>">
                   <?php if(isset($row['profile_pic'])) {
                       echo "<img src='img/u/" . $row['profile_pic'] . "' alt='user' class='user'>";
                   } else { echo "<img src='img/default.jpg' alt='user' class='user'>";}?>
            <?php echo $_SESSION['username']; ?></a>
        </div>
    </nav>

    <main>
        <div class="main-content">
            <div class="nav-links"> 
                <a href="index.php">Home</a>
                <a href="friends.php">Friends</a>
                <a href="actions/logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
            </div>
            <div class="posts">
                <div class="createPost-box">
                    <a href="user/profile.php?user_id=<?php echo $userId ?>">
                        <?php 
                        //Check if profile pic exists
                        if(isset($row['profile_pic'])) {
                            echo "<img src='img/u/" . $row['profile_pic'] . "' alt='user'>";
                        } else { 
                            echo "<img src='img/default.jpg' alt='user'>";
                        }?>
                    <a class="createPost" href="user/createPost.php?user_id=<?php echo $userId ?>">Create Post</a>
                </div>
                <?php 
                    include "actions/queries.php";
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
            <div class="other-content">
                <div class="sortPosts">
                    <h2>Sort Posts by</h2>
                    <div class="sort-btn">
                        <a href="index.php?sort=date">Date</a>
                        <a href="index.php?sort=likes">Likes</a>
                        <a href="index.php?sort=random">Random</a>
                        <a href="index.php?sort=comments">Comments</a>
                    </div>
                </div>
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

    
    <?php else: header("Location: auth/login.php") ?>
    <?php endif; ?>
</body>
</html>