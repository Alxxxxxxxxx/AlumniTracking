<?php
$server = "localhost";
$username = "root";
$password = ""; // Set your MySQL password
$database = "school_alumni";

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
