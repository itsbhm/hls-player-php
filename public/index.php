<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome - HLS Video Player</title>
</head>
<body>
    <h1>Welcome to the HLS Player!</h1>
    <p>You are logged in.</p>
    <p><a href="player.php">Go to Video Player</a></p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
