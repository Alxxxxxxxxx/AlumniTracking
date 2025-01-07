<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include '../../Backend/db_connect.php';

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 

    $sql = "INSERT INTO alumni (username, email, password) 
            VALUES ('$username', '$email', '$password')";
    
    if (mysqli_query($conn, $sql)) {
        header('Location: ../login.php');
        exit(); 
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required />
    <input type="email" name="email" placeholder="Email" required />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit">Sign Up</button>
</form>

<p>
    <a href="../login.php" style="text-decoration: none; color: #ab140a; font-weight: bold;">Back to Login</a>
</p>
