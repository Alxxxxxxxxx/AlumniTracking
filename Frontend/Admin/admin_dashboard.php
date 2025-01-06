<?php
session_start();

if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../../login.php');  // Redirect if not logged in as admin
    exit();
}

?>
<h1>Admin Dashboard</h1>
<p>Welcome, Admin!</p>
