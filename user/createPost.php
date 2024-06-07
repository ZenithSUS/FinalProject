<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST' ) {
        include "../actions/queries.php";
        createPost();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/createPost.css">
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
                <a href="../friends.php">Friends</a>
                <a href="../actions/logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
            </div>
            <div class="createPost">
                <div class="createForm-container">
                    <h2>Create Post</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <input type="text" name="title" placeholder="Title">
                        <?php if(isset($_GET['error'])) { echo "<p class='error'>" . $_GET['error'] . "</p>"; } ?>
                        <textarea name="content" id="" cols="30" rows="10" placeholder="Write something..."></textarea>
                        <div class="createPost-btn">
                            <button type="submit" name="createPost">Post</button>
                            <a href="../index.php">Go back</a>
                        </div>
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