<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/login_register.css">
    <title>Login</title>
</head>
<body>
    <!-- Intiaties a session -->
    <?php session_start(); 
        if(isset($_SESSION['user_id'])): header("Location: index.php"); 
    ?>
    <?php endif; ?>
    <!-- Login Container -->
    <div class="container">
        <form action="../actions/login_act.php" method="post" class="loginForm">
        <h1>Login</h1>
            <div class="form-group">
                <label for="useracc">Username or Email</label>
                <input type="text" name="useracc" id="useracc" placeholder="Enter username or email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter password">
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Login</button>
            </div>
            <?php if(isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <div class="auth-options">
                <p>Don't have an account? <a href="register.php">Register</a></p>
                <p>Forgot Password? <a href="forgot.php">Click here</a></p>
            </div>
        </form>
    </div>
</body>
</html>