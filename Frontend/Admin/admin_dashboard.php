<?php
session_start();

// Check if the session exists and the user is an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: LandingPage.php');  // Redirect if not logged in as admin
    exit();
}
?>
<h1>Admin Dashboard</h1>
<p>Welcome, Admin!</p>

<a href="../../logout.php">Logout</a>
