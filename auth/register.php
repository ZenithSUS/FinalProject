<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/login_register.css">
    <title>Register</title>
</head>
<body>
    <?php session_start(); 
        if(isset($_SESSION['user_id'])): header("Location: index.php"); 
    ?>
    <?php endif; ?>
    <div class="container">
        <form action="actions/register_act.php" method="post" class="regForm">
            <h1>Register</h1>
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
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" value="<?php if(isset($_GET['password'])) echo $_GET['password']; ?>">
                <span class="error"><?php if(isset($_GET['passError'])) echo $_GET['passError']; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Confirm password</label>
                <input type="password" name="confirm_password" id="confirm_password" value="<?php if(isset($_GET['confirm_password'])) echo $_GET['confirm_password']; ?>">
            </div>
            <?php if(isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <button type="submit" name="submit">Register</button>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
    <script src="../scripts/registerVaidation.js"></script>
</body>
</html>