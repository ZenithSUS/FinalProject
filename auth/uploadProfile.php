<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/uploadProfile.css">
    <title>Login</title>
</head>
<body>
    <!-- Intiaties a session -->
    <?php
        session_start();
        if(!isset($_SESSION['user_id'])): header("Location: login.php"); 
    ?>
    <?php endif; ?>
    <!-- Profile Form Container -->
    <div class="profile-container">
        <form action="../actions/uploadPic_act.php" method="post" class="loginForm" enctype="multipart/form-data">
            <h1>Upload Profile Picture</h1>
            <div class="form-group">
                <img src="../img/default.jpg" alt="user" id="profilePic">
                <label for="profilePic">Picture</label>
                <input type="file" name="profilePic" accept="image/*" id="file_input">
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Upload</button>
            </div>
            <?php if(isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
        </form>
    </div>
    <script src="../scripts/displayPic.js"></script>
</body>
</html>