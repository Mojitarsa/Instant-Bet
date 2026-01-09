<?php
require "db.php";

if (!isset($_GET['token'])) {
    die("Invalid request");
}

$token = $_GET['token'];

$stmt = mysqli_prepare($conn,
    "SELECT id FROM users
     WHERE reset_token=? AND reset_expires > NOW()"
);
mysqli_stmt_bind_param($stmt, "s", $token);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id);
mysqli_stmt_fetch($stmt);

if (!$id) {
    die("Reset link expired or invalid");
}

if (isset($_POST['new_password'])) {
    $newPass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn,
        "UPDATE users
         SET password=?, reset_token=NULL, reset_expires=NULL
         WHERE id=?"
    );
    mysqli_stmt_bind_param($stmt, "si", $newPass, $id);
    mysqli_stmt_execute($stmt);

    echo "✅ Password updated. <a href='index.php'>Login</a>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-box">
    <h2>Reset Password</h2>

    <form method="POST">
        <input type="password" name="password" placeholder="New password" required>
        <button type="submit" name="new_password">Reset Password</button>
    </form>
</div>

</body>
</html>
