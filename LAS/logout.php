<?php
// Start session to access session variables
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect user to login page after logout
header("Location: login.php");
exit();
?>
