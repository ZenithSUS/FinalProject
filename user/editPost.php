<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/editPost.css">
    <!-- Title -->
    <title>Edit Post</title>
</head>
<body>
    <!-- Start Session -->
    <?php
    session_start();
    // Include session checker
    include_once "session.php";
    // Check if the session is set
    if(!isset($_SESSION['user_id']) || !isset($_COOKIE['user_id'])){
        header("Location: ../auth/login.php");
    } else {
        checkSessionTimeout();
    }
    ?>
    <?php
        // include queries
        include "../queries/post.php";
        include "../queries/friend.php";
        include "../queries/greek.php";
        // include db connection
        include "../db.php";
    ?>
    <!-- Navigation -->
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
        <div class="profile-link">
        <?php
            //Get user id 
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
        <!-- Edit Content -->
        <div class="edit-content">
            <div class="nav-links"> 
                <a href="../index.php">Home</a>
                <a href="../friends.php" class="friends">Friends
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

            <!-- Edit Post Container -->
            <div class="editPost">
                <?php
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
                    <!-- Heading or Title -->
                    <h2>Edit Post</h2>
                    <!-- Edit Post Form -->
                    <form action="../actions/editPost_act.php?post_id=<?php echo $post['post_id']; ?>" method="POST">
                        <!-- Title Field -->
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" placeholder="Title" value="<?php echo $post['title']; ?>">
                        </div>
                        <!-- Error Message -->
                        <?php if(isset($_GET['error'])) { echo "<p class='error'>" . $_GET['error'] . "</p>"; } ?>
                        <!-- Content Field -->
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" id="" cols="30" rows="10" placeholder="Write something..."><?php echo htmlspecialchars($cleanedText); ?></textarea>
                        </div>
                        <!-- Edit Post Button -->
                        <div class="editPost-btn">
                            <button type="submit" name="editPost">Edit</button>
                            <a href="../index.php">Go back</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Other Content Area -->
            <div class="other-content">
                <!-- Others Container -->
                <div class="others">
                    <!-- Heading or Title -->
                    <h2>Greek Gods</h2>
                        <!-- Heroes Container -->
                        <div class="heroes">
                            <?php 
                                //Get heroes
                                $heroes = getGreeksUser($conn);
                            ?>
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