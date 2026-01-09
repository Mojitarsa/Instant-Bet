<?php
require "db.php";

if (isset($_POST['reset'])) {
    $email = $_POST['email'];

    $token = bin2hex(random_bytes(32));
    $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

    $stmt = mysqli_prepare($conn,
        "UPDATE users SET reset_token=?, reset_expires=? WHERE email=?"
    );
    mysqli_stmt_bind_param($stmt, "sss", $token, $expires, $email);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $link = "http://localhost/login-system/reset.php?token=$token";

        // LOCALHOST TEST (no email)
        echo "Password reset link:<br>";
        echo "<a href='$link'>$link</a>";
        exit();
    } else {
        echo "Email not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-box">
    <h2>Forgot Password</h2>

    <form method="POST">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit" name="reset">Send Reset Link</button>
    </form>

    <p class="signup-text">
        <a href="index.php">Back to login</a>
    </p>
</div>

</body>
</html>
