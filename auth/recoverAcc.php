<?php
    //Intialize session
    session_start();

    //Check if the session is set
    if(isset($_SESSION['user_id'])) {
        echo "<script>window.location.href = '../index.php'</script>";
    }

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/forgot.css">
    <!-- Title -->
    <title>Account Recovery</title>
</head>
<body>
    <!-- Forgot Password Container -->
    <div class="container">
        <!-- Forgot Password Form -->
        <form action="../actions/recover_act.php" method="post" class="forgotForm">
            <!-- Heading or Title -->
            <h1>Recover Account</h1>
            <!-- Token Field -->
            <div class="form-group">
                <label for="token">Token No.</label>
                <input type="text" name="token" id="token" placeholder="Enter token recovery">
                <span class="error"><?php if(isset($_GET['tokenError'])) echo $_GET['tokenError']; ?></span>
            </div>
            <!-- Password Field -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter new password">
            </div>
            <!-- Confirm Password Field -->
            <div class="form-group">
                <label for="cpassword">Confirm Password</label>
                <input type="password" name="cpassword" id="cpassword" placeholder="Confirm new password">
                <span class="error"><?php if(isset($_GET['cpasswordError'])) echo $_GET['cpasswordError']; ?></span>
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
                <button type="submit" name="recoverPasswordForm">Reset Password</button>
            </div>
            <!-- Error Message -->
            <?php if(isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <!-- Auth Options -->
            <div class="auth-options">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>

    <!-- Script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>