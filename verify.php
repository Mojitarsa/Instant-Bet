<?php
require "db.php";

if (!isset($_GET['token'])) {
    die("Invalid verification link.");
}

$token = $_GET['token'];

// Find user with this token
$stmt = mysqli_prepare($conn,
    "SELECT id FROM users WHERE verification_token = ?"
);
mysqli_stmt_bind_param($stmt, "s", $token);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 1) {

    // Verify user
    $update = mysqli_prepare($conn,
        "UPDATE users 
         SET is_verified = 1, verification_token = NULL 
         WHERE verification_token = ?"
    );
    mysqli_stmt_bind_param($update, "s", $token);
    mysqli_stmt_execute($update);

    echo "<h2 style='color:green'>✅ Account verified successfully!</h2>";
    echo "<a href='index.php'>Go to Login</a>";

} else {
    echo "<h2 style='color:red'>❌ Invalid or expired link</h2>";
}
?>
