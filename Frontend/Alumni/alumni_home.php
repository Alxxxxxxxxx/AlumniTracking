<?php
session_start();

// Check if the session exists and the user is an alumni
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'alumni') {
    header('Location: LandingPage.php');  // Redirect if not logged in as alumni
    exit();
}

// Get user data from the session
$user = $_SESSION['user'];
?>
<h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
<p>ID Number: <?php echo htmlspecialchars($user['id_number']); ?></p>
<p>Age: <?php echo htmlspecialchars($user['age']); ?></p>
<p>Nature of Work: <?php echo htmlspecialchars($user['nature_of_work']); ?></p>
<p>Address: <?php echo htmlspecialchars($user['address']); ?></p>
<p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
<p>Phone Number: <?php echo htmlspecialchars($user['phone_number']); ?></p>
<p>Graduation Year: <?php echo htmlspecialchars($user['graduation_year']); ?></p>
<p>Program of Study: <?php echo htmlspecialchars($user['program_of_study']); ?></p>

<a href="../../logout.php">Logout</a>
