<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/forgot.css">
    <title>Account Recovery</title>
</head>
<body>
    <div class="container">
        <form action="../actions/forgot_act.php" method="post" class="forgotForm">
            <h1>Account Recovery</h1>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter email">
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Recover</button>
            </div>
            <?php if(isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <div class="auth-options">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>