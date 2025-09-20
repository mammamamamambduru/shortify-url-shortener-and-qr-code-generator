<?php
// Log in
session_start();

// Destroy all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect the user to the home or login page
header("Location: ../login.php");
exit();
?>
