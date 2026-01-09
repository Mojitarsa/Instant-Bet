<?php
session_start();
include "db.php";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

        // ✅ Check password
        if (password_verify($password, $row['password'])) {

            // 🔒 CHECK VERIFIED
            if ($row['is_verified'] != 1) {
                header("Location: index.php?error=Please verify your account");
                exit();
            }

            // 🔒 STEP 3 — ADMIN ONLY (THIS IS THE KEY PART)
            if ($row['is_admin'] != 1) {
                header("Location: index.php?error=Access denied. Admin only");
                exit();
            }

            // ✅ LOGIN SUCCESS (ONLY YOU)
            $_SESSION['username'] = $row['username'];
            header("Location: dashboard.php");
            exit();

        } else {
            header("Location: index.php?error=Wrong password");
            exit();
        }

    } else {
        header("Location: index.php?error=User not found");
        exit();
    }
}
?>
