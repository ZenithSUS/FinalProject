<?php
    //Check if the form is submitted and the method is POST
    if($_SERVER['REQUEST_METHOD'] == 'POST' ) {
        //Include queries
        include "../actions/queries.php";

        //Call createPost function
        createPost();
    }
?>


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
    // Check if the session is set
    if(isset($_SESSION['user_id'])): 
    ?>
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

    <!-- Main Area -->
    <main>
        <div class="main-content">
            <!-- Nav Links -->
            <div class="nav-links"> 
                <a href="../index.php">Home</a>
                <a href="../friends.php">Friends</a>
                <a href="../heroes.php">Heroes</a>
                <a href="../actions/logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
            </div>

            <!-- Create Post Area -->
            <div class="createPost">
                <!-- Create Post Container -->
                <div class="createForm-container">
                    <!-- Heading or Title -->
                    <h2>Create Post</h2>
                    <!-- Create Post Form -->
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
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
                            <button type="submit" name="createPost">Post</button>
                            <a href="../index.php">Go back</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Other Content Area -->
            <div class="other-content">
                <!-- Other Content Container -->
                <div class="others">
                    <!-- Heading or Title -->
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
    </main>

    <!-- if not logged in redirect to login page -->
    <?php else: header("Location: ../auth/login.php") ?>
    <!-- End If Statement -->
    <?php endif; ?>
</body>
</html>