<?php
session_start();

// Destroy the session
session_unset();   // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to LandingPage.php after logout
header('Location: LandingPage.php');
exit();
?>
