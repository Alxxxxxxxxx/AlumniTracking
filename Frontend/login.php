<?php
session_start();
session_regenerate_id(true); // Regenerate session ID to prevent session fixation

include '../Backend/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verify reCAPTCHA
    $recaptchaSecret = '6LeswLAqAAAAAA5GuxqoGVOV0GQWMxRUdUxLAp6O';
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
    $responseData = json_decode($verifyResponse);

    if (!$responseData->success) {
        $error = "reCAPTCHA verification failed. Please try again.";
    } else {
        // Sanitize user inputs
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Query for admin (only using username)
        $sqlAdmin = "SELECT * FROM admin WHERE username = ?"; 
        $stmtAdmin = $conn->prepare($sqlAdmin);

        // Check if prepare was successful
        if ($stmtAdmin === false) {
            die('Error preparing SQL query for admin: ' . $conn->error);
        }

        $stmtAdmin->bind_param("s", $username);
        $stmtAdmin->execute();
        $resultAdmin = $stmtAdmin->get_result();
        $rowAdmin = $resultAdmin->fetch_assoc();

        // Query for alumni (using either username or email)
        $sqlAlumni = "SELECT * FROM alumni WHERE username = ? OR email = ?";
        $stmtAlumni = $conn->prepare($sqlAlumni);

        // Check if prepare was successful
        if ($stmtAlumni === false) {
            die('Error preparing SQL query for alumni: ' . $conn->error);
        }

        $stmtAlumni->bind_param("ss", $username, $username);  // Search using username or email
        $stmtAlumni->execute();
        $resultAlumni = $stmtAlumni->get_result();
        $rowAlumni = $resultAlumni->fetch_assoc();

        // Check if user is found and verify password
        if ($rowAdmin && password_verify($password, $rowAdmin['password'])) {
            $_SESSION['user'] = $rowAdmin;
            $_SESSION['user_type'] = "admin";
            header('Location: ../Frontend/Admin/admin_dashboard.php');
            exit();
        } elseif ($rowAlumni && password_verify($password, $rowAlumni['password'])) {
            $_SESSION['user'] = $rowAlumni;
            $_SESSION['user_type'] = "alumni";
        
            // Check if the alumni has filled in the information
            if (empty($rowAlumni['last_name']) || empty($rowAlumni['first_name']) || empty($rowAlumni['present_address']) || empty($rowAlumni['contact_number']) || empty($rowAlumni['current_status']) || empty($rowAlumni['university_employer']) || empty($rowAlumni['position_year_level']) || empty($rowAlumni['type_of_employment']) || empty($rowAlumni['year_hired']) || empty($rowAlumni['strand']) || empty($rowAlumni['years_of_enrollment']) || empty($rowAlumni['involvement']) || empty($rowAlumni['academic_awards']) || empty($rowAlumni['privacy_consent']) || empty($rowAlumni['sector']) || empty($rowAlumni['type_of_employment']) || empty($rowAlumni['sector'])) {
                // Redirect to alumni form if required fields are missing
                header('Location: ../Frontend/Alumni/alumni_form.php');
            } else {
                // Redirect to alumni home if the information is complete
                header('Location: ../Frontend/Alumni/alumni_home.php');
            }
            exit();
        } else {
            $error = "Invalid username or password!";
        }
    }
}
?>


<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Alumni Tracking System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
            background: url('../images/namebg.png') no-repeat center center fixed;
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
        .login-container input[type="password"] {
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
            margin-top: 0;
            margin-bottom: 20px;
            color: black;
            font-size: 2.5rem;
            font-weight: lighter;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
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
                <img alt="jee" src="../images/banner.png" class="logoimg">
            </div>
            <div class="banner_text">
                <h1>SACRED HEART OF JESUS CATHOLIC SCHOOL</h1>
                <h2>HOME OF THE MEEK AND HUMBLE</h2>
            </div>
        </div>
    </div>
    <div class="login-container">
    <a href="../LandingPage.php" class="back-button"><i class="fas fa-arrow-left"></i> Back</a>
        <h2>Welcome Alumnus!</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username or Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <div class="captcha-container">
                <div class="g-recaptcha" data-sitekey="6LeswLAqAAAAANMxYj8aJkCz8UimL0NOJ3drnCfQ"></div>
            </div>
            <?php if (isset($error)): ?>
                <p style="color: #da1a32;;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <button type="submit">Login</button>
        </form>
        <p class="suh">If not yet have an account, <a href="../Frontend/Alumni/signup.php" class="suh2">sign up here</a>.</p>
    </div>
</body>
</html>
