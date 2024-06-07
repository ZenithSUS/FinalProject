<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/editPost.css">
    <title>Edit Post</title>
</head>
<body>
    <!-- Start Session -->
    <?php
    session_start();
    // Check if the session is set
    if(isset($_SESSION['user_id'])): 
    ?>
    <!-- Navigation -->
    <nav>
        <h2> Greek Myth </h2>
            <input type="text" placeholder="Search" id="search" class="search">
        <div class="profile-link">
        <?php 
            $userId = $_SESSION['user_id'];
            include "../db.php";
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

    <main>
        <!-- Main Content -->
        <div class="main-content">
            <div class="nav-links"> 
                <a href="../index.php">Home</a>
                <a href="../friends.php">Friends</a>
                <a href="../actions/logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
            </div>

            <!-- Edit Post Container -->
            <div class="editPost">
                <?php
                    include "../db.php";

                    // Get post id
                    $post = $_GET['post_id'];    
                    // Get post data
                    $sql = "SELECT * FROM posts WHERE post_id = '$post'";
                    $result = $conn->query($sql) or die($conn->error);
                    $post = $result->fetch_assoc();

                    // Get cleaned text
                    $originalText = $post['content'];
                    $cleanedText = strip_tags($originalText);

                ?>
                <!-- Edit Post Form -->
                <div class="editForm-container">
                    <h2>Edit Post</h2>
                    <form action="editPost_act.php?post_id=<?php echo $post['post_id']; ?>" method="POST">
                        <div class="form-group"> 
                            <label for="title">Title</label>
                            <input type="text" name="title" placeholder="Title" value="<?php echo $post['title']; ?>">
                        </div>
                        <?php if(isset($_GET['error'])) { echo "<p class='error'>" . $_GET['error'] . "</p>"; } ?>
                        <div class="form-group">
                            <label for="content">Content</label>
                                <textarea name="content" id="" cols="30" rows="10" placeholder="Write something..." >
                                    <?php echo $cleanedText; ?>
                                </textarea>
                        </div>
                        <div class="editPost-btn">
                            <button type="submit" name="editPost">Edit</button>
                            <a href="../index.php">Go back</a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Other Content -->
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

    <!-- if not logged in redirect to login page -->
    <?php else: header("Location: auth/login.php") ?>
    <?php endif; ?>
</body>
</html>