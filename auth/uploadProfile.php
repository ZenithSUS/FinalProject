<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/uploadProfile.css">
    <!-- Title -->
    <title>Login</title>
</head>
<body>
    <!-- Intiaties a session -->
    <?php
        session_start();
        // Check if the session is not set
        if(!isset($_SESSION['user_id'])): header("Location: login.php"); 
    ?>
    <?php endif; ?>
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
                <button type="submit" name="submit">Upload</button>
                <button type="submit" name="submit">Later</button>
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