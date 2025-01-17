<?php
$server = "localhost";
$username = "u349903409_SchoolAlumni";
$password = "SchoolAlumni123"; // Set your MySQL password
$database = "u349903409_SchoolAlumni";

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
