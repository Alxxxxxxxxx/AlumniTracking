<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Alumni Tracking System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noticia+Text&display=swap" rel="stylesheet">
    <link rel="icon" href="images/logo.ico" type="image/logo">
    <link href="table.css" type="text/css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            font-family: 'Shrikhand', sans-serif;
        }

        /* Background Image */
        body {
            background: url('images/nameback.png') no-repeat center center fixed;
            background-size: cover;
        }

        /* Login Container */
        .login-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(255, 255, 255, 0.53);
    padding: 100px;
    border-radius: 50px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    width: 800px;
    height: 300px;
    text-align: center;
}

        .login-container h2 {
            font-family: 'Shrikhand', sans-serif;
            margin-bottom: 20px;
            color:rgb(255, 255, 255);
            font-size: 2rem;
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
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background: #ab140a;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .login-container button:hover {
            background: #8c1b10;
        }
        .top_banner {
            height: 120px;
            width: 100%;
            background: transparent;
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
            color: #fbfff2;
            margin: 0;
            padding: 0;
            font-weight: normal;
            font-family: 'Shrikhand', cursive;
        }

        .banner_text h2 {
            font-size: 25pt;
            color: #fbfff2;
            margin: 0;
            margin-top: -20px;
            padding: 0;
            font-weight: normal;
            font-family: 'Noticia Text', serif;
        }

        .glogo {
            width: 102px;
            height: 120px;
            float: left;
            margin: 0px 5px 0 5px;
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
    </style>
</head>
<body>
<div class="top_banner">
        <div class="in_banner">
            <div class="logo">
                <img alt="jee" src="images/banner.png">
            </div>
            <div class="banner_text">
                <h1>SACRED HEART OF JESUS CATHOLIC SCHOOL</h1>
                <h2>HOME OF THE MEEK AND HUMBLE</h2>
            </div>
        </div>
    </div>
    <div class="login-container">
    <div class="arrow-back">
            <i class="fas fa-arrow-left"></i> Back
        </div>
        <div class="d-line"><h2>Welcome to the Alumnus!</d2></div>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Username" required class="input-field">
            <input type="password" name="password" placeholder="Password" required class="input-field">
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
