<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/comment.css">
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
            <?php $userId = $_SESSION['user_id']; ?>
            <a href="profile.php?user_id=<?php echo $userId ?>"><img src="../img/default.jpg" alt="user" class="user"></a>
        <?php echo "<strong style='font-size: 20px;'>".$_SESSION['username']."</strong>"; ?>
        </div>
    </nav>

    <main>
        <div class="main-content">
            <div class="nav-links"> 
                <a href="../index.php">Home</a>
                <a href="friends.php">Friends</a>
                <a href="../actions/logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
            </div>
            <div class="posts">
            <?php include "../actions/queries.php";
                $postId = $_GET['post_id'];
                $userId = $_SESSION['user_id'];
                currentPost($postId, $userId);  
                comments();?>
                
       
            <div class='comment-form'>
                <h2>What are your thoughts</h2>
                <form action='actions/comment_act.php' method='post'>
                <input type='hidden' name='post_id' value='" . $postId . "'>
                <textarea name='comment' id='comment' cols='30' rows='10'></textarea>
                <button type='submit' name='submit'>Post</button>
                </form>
            </div>

            </div>
            <div class="other-content">
                <div class="others">
                    <h2>Greek Heroes Page</h2>
                        <div class="heroes">
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
    </main>

    
    <?php else: header("Location: ../auth/login.php") ?>
    <?php endif; ?>
</body>
</html>