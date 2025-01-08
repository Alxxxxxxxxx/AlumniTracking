<?php
session_start();


if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: LandingPage.php'); 
    exit();
}

include '../../Backend/db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM alumni WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header('Location: admin_dashboard.php'); 
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
