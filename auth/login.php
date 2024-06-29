<?php session_start();
        // Check if the session is set 
        if(isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])): 
            echo "<script>window.location.href = '../index.php'</script>";
?>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/login_register.css">
    <!-- Title -->
    <title>Login</title>
</head>
<body>
    <!-- Login Container -->
    <div class="logContainer">
        <!-- Login Form -->
        <form action="../actions/login_act.php" method="post" class="loginForm">
        <!-- Heading or Title -->
        <h1>Login</h1>
            <!-- Username or Email Field -->
            <div class="form-group">
                <label for="useracc">Username or Email</label>
                <input type="text" name="useracc" id="useracc" placeholder="Enter username or email">
            </div>
            <!-- Password Field -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter password">
            </div>
            <!-- Captcha -->
            <div class="form-group-captcha">
                <!-- Google Captcha -->
                <label for="captcha">Verify you are not a robot</label>
                <div class="g-recaptcha" data-sitekey="6LdTPAMqAAAAAAwSa-hXYXlAqoVsM9hK9SoFMEfF"></div>
                <span class="error"><?php if(isset($_GET['captchaError'])) echo $_GET['captchaError']; ?></span>
            </div>
            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit" name="submit">Login</button>
            </div>
            <!-- Error Message -->
            <?php if(isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <!-- Auth Options -->
            <div class="auth-options">
                <p>Don't have an account? <a href="register.php">Register</a></p>
                <p>Forgot Password? <a href="forgot.php">Click here</a></p>
            </div>
        </form>
    </div>

    <!-- Script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>