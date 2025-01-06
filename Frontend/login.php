<?php
session_start();
include '../Backend/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize user inputs (important for security)
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['user_type']; // Either "alumni" or "admin"

    // Prepare SQL statement to prevent SQL injection
    if ($userType === "alumni") {
        // For alumni, prepare statement
        $sql = "SELECT * FROM alumni WHERE id_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username); // "s" stands for string
    } else {
        // For admin, prepare statement
        $sql = "SELECT * FROM admin WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username); // "s" stands for string
    }

    // Execute prepared query
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Check if the user was found and password matches
    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['user'] = $row;
        $_SESSION['user_type'] = $userType;

        // Redirect based on user type
        if ($userType === "alumni") {
            header('Location: ../Frontend/Alumni/alumni_home.php');
        } else {
            header('Location: ../Frontend/Admin/admin_dashboard.php');
        }
        exit();
    } else {
        echo "Invalid login!";
    }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Username/ID Number" required />
    <input type="password" name="password" placeholder="Password" required />
    <select name="user_type">
        <option value="alumni">Alumni</option>
        <option value="admin">Admin</option>
    </select>
    <button type="submit">Login</button>
</form>
