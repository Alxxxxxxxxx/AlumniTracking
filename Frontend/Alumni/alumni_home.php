<?php
session_start();

if ($_SESSION['user_type'] !== 'alumni') {
    header('Location: ../../login.php');  // Redirect if not logged in as alumni
    exit();
}

$user = $_SESSION['user'];
?>
<h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
<p>ID Number: <?php echo htmlspecialchars($user['id_number']); ?></p>
<p>Age: <?php echo htmlspecialchars($user['age']); ?></p>
<p>Nature of Work: <?php echo htmlspecialchars($user['nature_of_work']); ?></p>
<p>Address: <?php echo htmlspecialchars($user['address']); ?></p>
