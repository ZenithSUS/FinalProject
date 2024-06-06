<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="heroes.css">
    <title>Heroes</title>
</head>
<body>
<?php
    session_start();
    if(isset($_SESSION['user_id'])): 
    ?>
    <nav>
        <div>
            <img src="img/logo.png" alt="logo">
        </div>
        <div class="nav-links"> 
            <a href="index.php" class="active">Home</a>
            <a href="auth/actions/logout.php">Logout</a>
        </div>
        <div>
            <img src="img/user.png" alt="user">
            <?php echo $_SESSION['username']; ?>
        </div>
    </nav>

    <main>
        <h1>Greek Myth</h1>
        <p>Welcome, <?php echo $_SESSION['username']; ?></p>
    </main>

    
    <?php else: header("Location: auth/login.php") ?>
    <?php endif; ?>
</body>
</html>