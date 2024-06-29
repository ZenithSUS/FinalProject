<?php 
    // Initialize session
    session_start();
    // Check if the session is set  
    if(isset($_SESSION['user_id']) ): 
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
    <title>Register</title>
</head>
<body 
 style="background-image: url(../img/backgrounds/abandon.jpg); background-size: cover; background-position: center; background-repeat: no-repeat">
    <!-- Register Container -->
    <div class="regContainer">
        <!-- Register Form -->
        <form action="../actions/register_act.php" method="post" class="regForm">
            <!-- Heading or Title -->
            <h1>Register</h1>
            <!-- Username or Email Field -->
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" oninput="userAvailable()" value="<?php if(isset($_GET['username'])) echo $_GET['username']; ?>">
                <span class="error" id="userError"><?php if(isset($_GET['userError'])) echo $_GET['userError']; ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" oninput="emailAvailable()" value="<?php if(isset($_GET['email'])) echo $_GET['email']; ?>">
                <span class="error" id="emailError"><?php if(isset($_GET['emailError'])) echo $_GET['emailError']; ?></span>
            </div>
            <!-- Password Field -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" value="<?php if(isset($_GET['password'])) echo $_GET['password']; ?>">
                <span class="error"><?php if(isset($_GET['passError'])) echo $_GET['passError']; ?></span>
            </div>
            <!-- Confirm Password Field -->
            <div class="form-group">
                <label for="password">Confirm password</label>
                <input type="password" name="confirm_password" id="confirm_password" value="<?php if(isset($_GET['confirm_password'])) echo $_GET['confirm_password']; ?>">
            </div>
            <!-- Captcha -->
            <div class="form-group-captcha">
                <!-- Google Captcha -->
                <label for="captcha">Verify you are not a robot</label>
                <div class="g-recaptcha" data-sitekey="6LdTPAMqAAAAAAwSa-hXYXlAqoVsM9hK9SoFMEfF"></div>
                <span class="error"><?php if(isset($_GET['captchaError'])) echo $_GET['captchaError']; ?></span>
            </div>
            <!-- Error Message -->
            <?php if(isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <!-- Submit Button -->
            <button type="submit" name="submit">Register</button>
            <!-- Auth Options -->
            <p class="auth-register">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>

    <!-- Scripts -->
    <script src="../scripts/registerVaidation.js"></script>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
</body>
</html>