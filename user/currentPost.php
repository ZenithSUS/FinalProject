<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/index.css">
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
            <img src="../img/default.jpg" alt="user" class="user">
            <?php echo "<strong style='font-size: 20px;'>".$_SESSION['username']."</strong>"; ?>
        </div>
    </nav>

    <main>
        <div class="main-content">
            <div class="nav-links"> 
                <a href="../index.php">Home</a>
                <a href="friends.php">Friends</a>
                <a href="auth/actions/logout.php">Logout</a>
            </div>
            <div class="posts">
            <?php
                include "../db.php";
                $postId = $_GET['post_id'];
                $result = $conn->query("SELECT * FROM posts JOIN users ON posts.author = users.user_id WHERE posts.post_id = '$postId'");
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='post'>";
                        echo "<img src='img/user.png' alt='user'>";
                        echo "<h3>" . $row['title'] . " Posted by " . $row['username'] .  "</h3>";
                        echo "<p>" . $row['content'] . "</p>";
                        echo "<hr>";
                        echo "</div>";
                    }
                ?>
            <?php
                include "../db.php";

                /*
                $postId = $_GET['post_id'];
                $result = $conn->query("SELECT * FROM comments JOIN users ON comments.author = users.user_id WHERE comments.post_id = '$postId'");
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='comment'>";
                        echo "<img src='img/user.png' alt='user'>";
                        echo "<h3>" . $row['username'] . "</h3>";
                        echo "<p>" . $row['content'] . "</p>";
                        echo "<hr>";
                        echo "</div>";
                    }*/
                echo "<div class='comment-form'>";
                echo "<h2>What are your thoughts</h2>";
                echo "<form action='actions/comment_act.php' method='post'>";
                echo "<input type='hidden' name='post_id' value='" . $postId . "'>";
                echo "<textarea name='comment' id='comment' cols='30' rows='10'></textarea>";
                echo "<button type='submit' name='submit'>Post</button>";
                echo "</form>";
                echo "</div>";
            ?>
            </div>
            <div class="discussion">
                <h2>Greek Heroes Page</h2>
                <div class="heroes">
                    <img src="img/hero.png" alt="hero"><p>Zeus</p>
                    <img src="img/hero.png" alt="hero"><p>Poseida</p>
                    <img src="img/hero.png" alt="hero"><p>Heracles</p>
                    <img src="img/hero.png" alt="hero"><p>Perseus</p>
                </div>
            </div>
        </div>
    </main>

    
    <?php else: header("Location: auth/login.php") ?>
    <?php endif; ?>
</body>
</html>