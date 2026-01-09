<?php
require "db.php";

$error = '';
$success = '';

if (isset($_POST['signup'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Check if user exists
    $check = mysqli_query($conn,
        "SELECT * FROM users WHERE username='$username' OR email='$email'"
    );

    if (mysqli_num_rows($check) > 0) {
        $error = "Username or email already exists";
    } else {

        $token  = bin2hex(random_bytes(32));
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($conn,
            "INSERT INTO users (username, email, password, verification_token, is_verified)
             VALUES (?, ?, ?, ?, 0)"
        );

        mysqli_stmt_bind_param($stmt, "ssss",
            $username, $email, $hashed, $token
        );

        if (mysqli_stmt_execute($stmt)) {
            $success = "Account created! Click below to verify.";

            // STEP 2 — SHOW VERIFICATION LINK
            echo "<p class='success'>Account created!</p>";
            echo "<a href='verify.php?token=$token'>Click here to verify</a>";
            exit();
        } else {
            $error = "Signup failed.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-box">
    <h2>Create Account</h2>

    <!-- Messages -->
    <?php if ($error != '') { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>
    <?php if ($success != '') { ?>
        <p class="success"><?php echo $success; ?></p>
    <?php } ?>

    <form action="signup.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="signup">Sign Up</button>
    </form>

    <p class="signup-text">
        Already have an account? <a href="index.php">Login</a>
    </p>
</div>

</body>
</html>