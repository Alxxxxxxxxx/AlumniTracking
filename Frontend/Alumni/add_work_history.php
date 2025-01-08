<?php
session_start();
include('../../Backend/db_connect.php');

// Check if the session exists and the user is an alumni
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'alumni') {
    header('Location: LandingPage.php');  // Redirect if not logged in as alumni
    exit();
}

// Get the alumni email from session
$alumni_email = $_SESSION['user']['email'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data to prevent SQL injection
    $company_name = htmlspecialchars($_POST['company_name']);
    $position = htmlspecialchars($_POST['position']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $job_description = htmlspecialchars($_POST['job_description']);

    // Prepare and execute the SQL statement to insert the data
    $sql = "INSERT INTO work_history (alumni_email, company_name, position, start_date, end_date, job_description) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $alumni_email, $company_name, $position, $start_date, $end_date, $job_description);

    if ($stmt->execute()) {
        // Redirect to alumni home page after successful insertion
        header("Location: alumni_home.php?status=success");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Work History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noticia+Text&display=swap" rel="stylesheet">
    <link rel="icon" href="../../images/logo.ico" type="image/logo">
    <style>
        body {
            font-family: 'Noticia Text', serif;
            background: url('../../images/namebg.png') no-repeat center center fixed;
            background-size: cover;
            color: #222222;
        }
        .container {
            background-color: #fafafa;
            height: 100vh;
            z-index: -2;
            box-shadow: -15px 0 20px rgba(0, 0, 0, 0.2), 15px 0 20px rgba(0, 0, 0, 0.2);
            padding-left: 10px; 
            padding-right: 10px; 
        }

        .logo {
            padding-top: 30px;
            width: 107px;
            height: 112px;
            position: relative; 
            left: 50%;
            transform: translateX(-50%); 
            z-index: 1;
        }

        h1 {
            font-size: 3rem;
            color: #222222;
            text-align: center;
            font-family: 'Shrikhand', sans-serif;
            padding-top: 50px;
            margin-bottom: 70px;
        }

        .work-history-form {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            font-family: 'Noticia Text', serif;
            background-color: #a00c30;
            border-color: #a00c30;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #da1a32;
            border-color: #da1a32;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img alt="jee" src="../../images/banner.png">
        </div>
        <div class="work-history-form">
            <h1>Add Work History</h1>
            <form action="add_work_history.php" method="POST">
                <div class="mb-3">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" required>
                </div>
                <div class="mb-3">
                    <label for="position" class="form-label">Position</label>
                    <input type="text" class="form-control" id="position" name="position" required>
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date (Optional)</label>
                    <input type="date" class="form-control" id="end_date" name="end_date">
                </div>
                <div class="mb-3">
                    <label for="job_description" class="form-label">Job Description</label>
                    <textarea class="form-control" id="job_description" name="job_description" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Work History</button>
            </form>
        </div>
    </div>
</body>
</html>
