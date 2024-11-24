<?php
// Check if user is logged in
function checkLogin() {
    session_start();
    return isset($_SESSION['user_logged_in']);
}

// Generate secure token for session-based access (Optional, for token-based approach)
function generateToken() {
    return hash('sha256', uniqid(mt_rand(), true));
}
?>
