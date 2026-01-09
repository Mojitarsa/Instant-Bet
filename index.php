<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gas G-Ecco Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="login-box">
        <h2>Log into lucky number</h2>

        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit" name="login">Login</button>

            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
        </form>

        <p class="signup-text">
    <a href="forgot.php">Forgot password?</a>
</p>


        <p class="signup-text">
            Don`t have an account?
            <a href="signup.php">Sign Up</a>
        </p>
    </div>

</body>
</html>
