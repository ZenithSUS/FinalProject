<?php
    // Intiaties a session
    session_start();
    // Include session checker
    include "../session.php";
    // Check if the session is not set
    if(!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id'])){
        echo "<script>window.location.href = '../auth/login.php'</script>";
    } else {
        checkSessionTimeout();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/uploadProfile.css">
    <!-- Title -->
    <title>Upload Profile Picture</title>
</head>
<body>
    <!-- Profile Form Container -->
    <div class="profile-container">
        <!-- Profile Form -->
        <form action="../actions/uploadPic_act.php" method="post" class="profileForm" enctype="multipart/form-data">
            <!-- Profile Picture -->
            <h1>Upload Profile Picture</h1>
            <!-- Display Profile Picture -->
            <div class="form-group">
                <img src="../img/default.jpg" alt="user" id="profilePic">
                <label for="profilePic">Picture</label>
                <input type="file" name="profilePic" accept="image/*" id="file_input">
            </div>
            <!-- Bio Field -->
            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea name="bio" id="bio" cols="30" rows="10"></textarea>
            </div>
            <!-- Submit Button -->
            <div class="form-group">
                <div class="uploadBtns">
                    <button type="submit" name="picSubmit">Upload</button>
                    <button type="submit" name="noPicSubmit">Later</button>
                </div>
            </div>
            <!-- Error Message -->
            <?php if(isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
        </form>
    </div>

    <!-- Scripts -->
    <script src="../scripts/displayPic.js"></script>

</body>
</html>