<?php 

// Connect to db
$server = "localhost"; // Server Name
$user = "root"; // Username
$pass = ""; // Password
$database = "tech-blog"; // Database

// Connect statement
$conn = mysqli_connect($server, $user, $pass, $database);

// If connection failed display alert
if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}

?>