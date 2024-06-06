<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/profile.css">
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
                <a href="../friends.php">Friends</a>
                <a href="../actions/logout.php">Logout</a>
            </div>
            <div class="posts">
                <div class="profile-container">
                    <div class="profile-box">
                        <?php
                            include "../db.php";

                            $userId = $_GET['user_id'];
                            $result = $conn->query("SELECT * FROM users WHERE user_id = '$userId'");

                            $user = $result->fetch_assoc();
                            $date = strtotime($user['created_at']);
                            $date = date('F d, Y', $date);
                            $formattedDate = date('F d, Y', strtotime($date));

                            echo "<div>
                                    <img src='../img/default.jpg' alt='user'>
                                </div>";
                            echo "<div class='profile-info'>
                                    <h3>" . $user['username'] . "</h3>
                                    <h4>" ."Email: ". $user['email'] . "</h4>
                                    <h4>" . "Joined " . $formattedDate . "</h4>
                                    <p>" . $user['bio'] . "</p>
                                    <div class='profile-settings'>
                                        <a href='user/editProfile.php?user_id=" . $user['user_id'] . "'>Edit Profile</a>
                                        <a href='user/changePassword.php?user_id=" . $user['user_id'] . "'>Change Password</a>
                                    </div>
                                </div>";
                            echo "<hr>";
                        
                ?>
                    </div>
                </div>
            </div>
            <div class="discussion">
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
    </main>

    
    <?php else: header("Location: auth/login.php") ?>
    <?php endif; ?>
</body>
</html>