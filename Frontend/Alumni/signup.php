<?php
session_start();
include('../../Backend/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data from signup form
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    $checkEmail = "SELECT * FROM alumni WHERE email = '$email'";
    $result = $conn->query($checkEmail);
    if ($result->num_rows > 0) {
        $error = "Email Already Exist";
    } else {
        $sql = "INSERT INTO alumni (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['user_type'] = 'alumni'; 
            $_SESSION['user'] = ['email' => $email]; 

            header("Location: alumni_form.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Alumni Tracking System</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noticia+Text&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/logo.ico" type="image/logo">
    <link href="table.css" type="text/css" rel="stylesheet">
    <style>
        
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            font-family: 'Shrikhand', sans-serif;
            overflow-x: hidden; /* Prevent horizontal scrolling */
            background: url('../../images/namebg.png') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;

        }



        .login-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.5);
            padding: 100px;
            border-radius: 50px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 800px;
            height: 400px;
            text-align: center;
        }

        .login-container h2 {
            font-family: 'Shrikhand', sans-serif;
            margin-top: 0;
            margin-bottom: 20px;
            color: #FFF;
            font-size: 2.5rem;
            font-weight: lighter;
        }

        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container input[type="email"]  {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            font-family: 'Noticia Text', serif;
            box-sizing: border-box;
        }

        .login-container button { 
            width: 100%;
            padding: 10px;
            background: #a00c30;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            font-family: 'Noticia Text', serif;
            cursor: pointer;
            box-sizing: border-box;
        }

        .login-container button:hover {
            background: #222222;
        }

        /* Top Banner and Other Styles */
        .top_banner {
            height: auto;
            text-align: center; /* Center-align for mobile */
            padding: 20px;

        }

        .in_banner {
            width: 100%;
            margin: 0 auto;
            height: 120px;
            background: transparent;
        }

        .banner_text {
            float: left;
            width: 1000px;
            margin: 37px 0 0 30px;
            text-align: left;
        }

        .banner_text h1 {
            font-size: 25pt;
            color: white;
            margin: 0;
            padding: 0;
            font-weight: normal;
            font-family: 'Shrikhand', cursive;
        }

        .banner_text h2 {
            font-size: 25pt;
            color: white;
            margin: 0;
            margin-top: -20px;
            padding: 0;
            font-weight: normal;
            font-family: 'Noticia Text', serif;
        }


        .logo {
            float: left;
            width: 107px;
            height: 112px;
            margin: 20px 0 0 20px;
            cursor: pointer;
            z-index: 10; 
            position: relative; 
        }

        .captcha-container {
            display: flex;
            justify-content: center; 
            align-items: center; 
            margin: 20px 0;  
        }

        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color:transparent;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 1rem;
            font-family: 'Noticia Text', serif;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            font-weight: lighter;
        }
        
        .suh {
            background-color:transparent;
            border-radius: 10px;
            font-size: 1rem;
            font-family: 'Noticia Text', serif;
            text-decoration: none;
            font-weight: lighter;
            margin-top: 10px;
            margin-bottom: 20px;
            color: white;
            font-size: 1.2rem;
        }

        .suh2 {
            background-color:transparent;
            color: #222222;
            border-radius: 10px;
            font-size: 1rem;
            font-family: 'Noticia Text', serif;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 20px;
            font-size: 1.2rem;
            text-decoration: none;
        }

        .suh2:hover {
            color: #a00c30;
        }

        .back-button:hover {
            color: #222222;
        }

        .back-button i {
            margin-right: 5px;
        }

        @media only screen and (max-width: 600px) {

        .top_banner {
            display: flex;
            height: auto;
            text-align: center; /* Center-align for mobile */
            padding: 20px;
        }


        .in_banner {
            display: flex;
            width: 100%;
            margin: 0 auto;
            height: 120px;
            background: transparent;
        }

        .banner_text {
            float: none;
            width: 500px;
            margin: 0;
            margin-left: 50px;
            margin-top: 20px;
            text-align: left;
        }

        .banner_text h1 {
            font-size: 12pt;
            color: white;
            height: 50px;
            margin: 0;
            margin-left: 30px;
            padding: 0;
            font-weight: normal;
            font-family: 'Shrikhand', cursive;
        }

        .banner_text h2 {
            font-size: 10pt;
            color: white;
            margin: 0;
            margin-left: 30px;
            margin-top: 0px;
            padding: 0;
            font-weight: normal;
            font-family: 'Noticia Text', serif;
        }


        .logo {
            float: none;
            width: 30px;
            height: 30px;
            margin: 0;
            margin-top: 10px;
            cursor: pointer;
            z-index: 11; 
            position: relative; 
        }

        .logoimg{
        width: 80px;
        height: 80px;
        z-index: 10; 
        }

        .login-container {
        position: static;
        top: 0;
        left: 0;
        transform: none;
        background: rgba(255, 255, 255, 0.5);
        padding: 0;
        border-radius: 1px;
        box-shadow: none;
        width: 100%;
        height: 100%;
        text-align: center;
        }

        .login-container h2 {
        font-family: 'Shrikhand', sans-serif;
        margin-top: 20px;
        margin-bottom: 20px;
        color: black;
        font-size: 2.5rem;
        font-weight: lighter;
        }

        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container input[type="email"] {
        width: 80%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
        font-family: 'Noticia Text', serif;
        box-sizing: border-box;
        }

        .login-container button { 
        width: 80%;
        padding: 10px;
        background: #a00c30;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1.2rem;
        font-family: 'Noticia Text', serif;
        cursor: pointer;
        box-sizing: border-box;
        }

        .login-container button:hover {
        background: #222222;
        }

        .captcha-container {
        display: flex;
        justify-content: center; 
        align-items: center; 
        margin: 20px 0;  
        }

        .back-button {
        position: static;
        top: 0;
        left: 0;
        background-color:transparent;
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        font-size: 1rem;
        font-family: 'Noticia Text', serif;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        font-weight: lighter;
        }

        .suh {
        width: 80%;
        background-color:transparent;
        border-radius: 10px;
        font-size: 1rem;
        font-family: 'Noticia Text', serif;
        text-decoration: none;
        font-weight: lighter;
        margin: auto;
        margin-top: 10px;
        margin-bottom: 20px;
        color: white;
        font-size: 1.2rem;
        }

        .suh2 {
        background-color:transparent;
        color: #222222;
        border-radius: 10px;
        font-size: 1rem;
        font-family: 'Noticia Text', serif;
        font-weight: bold;
        margin-top: 10px;
        margin-bottom: 20px;
        font-size: 1.2rem;
        text-decoration: none;
        }

        .suh2:hover {
        color: #a00c30;
        }

        .back-button:hover {
        color: #222222;
        }

        .back-button i {
        margin-right: 5px;
        }

        }
    </style>
</head>
<body>
<div class="top_banner">
        <div class="in_banner">
            <div class="logo">
                <img alt="jee" src="../../images/banner.png" class="logoimg">
            </div>
            <div class="banner_text">
                <h1>SACRED HEART OF JESUS CATHOLIC SCHOOL</h1>
                <h2>HOME OF THE MEEK AND HUMBLE</h2>
            </div>
        </div>
    </div>


    <div class="login-container">
        <h2>Sign Up</h2>
                <form method="POST">
            <input type="text" name="username" placeholder="Username" required="required"/>
            <input type="email" name="email" placeholder="Email" required="required"/>
            <div style="position: relative; display: inline-block; width: 100%;">
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Password"
                    type="password" name="password" placeholder="Password" required pattern=".{8,12}" title="Password must be between 8 and 12 characters." 
                    style="padding-right: 40px; width: 100%;"/>
                <i
                    class="fas fa-eye"
                    id="togglePassword"
                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; font-size: 1.2rem; color: #888;"
                    aria-label="Toggle password visibility"></i>
            </div>
            <?php if (isset($error)): ?>
            <p style="color: #da1a32;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <button type="submit">Sign Up</button>
            <p>
                <a href="../login.php" class="suh2">Back to Login</a>
            </p>
        </form>

        </div>

        <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password'
                ? 'text'
                : 'password';
            passwordInput.setAttribute('type', type);
            togglePassword
                .classList
                .toggle('fa-eye-slash');
        });
        </script>

        </div>
</body>
</html>
