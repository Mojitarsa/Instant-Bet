<?php
$host = "localhost";
$user = "root";      // default for XAMPP
$pass = "";          // default for XAMPP
$db   = "login_system";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed");
}
?>