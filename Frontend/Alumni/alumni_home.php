<?php
session_start();
include('../../Backend/db_connect.php');

// Check if the session exists and the user is an alumni
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'alumni') {
    header('Location: LandingPage.php');  // Redirect if not logged in as alumni
    exit();
}

// Get user data from the session
$user_identifier = $_SESSION['user']['email']; // Use email as unique identifier

// Retrieve the alumni data from the database
$sql = "SELECT * FROM alumni WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_identifier);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $first_name = htmlspecialchars($row['first_name']);
    $last_name = htmlspecialchars($row['last_name']);
    $email = htmlspecialchars($row['email']);
    $contact_number = htmlspecialchars($row['contact_number']);
    $present_address = htmlspecialchars($row['present_address']);
    $strand = htmlspecialchars($row['strand']);
    $years_of_enrollment = htmlspecialchars($row['years_of_enrollment']);
    $current_status = htmlspecialchars($row['current_status']);
    $university_employer = htmlspecialchars($row['university_employer']);
    $position_year_level = htmlspecialchars($row['position_year_level']);
    $type_of_employment = htmlspecialchars($row['type_of_employment']);
    $year_hired = htmlspecialchars($row['year_hired']);
} else {
    echo "User data not found.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(36, 36, 36);
            color:rgb(31, 31, 31);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color:rgb(255, 234, 195);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(228, 228, 228, 0.5);
        }

        h1 {
            color: #ff4c4c;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            margin: 10px 0;
            font-size: 1.1em;
        }

        strong {
            color: #ff6666;
        }

        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #ffffff;
            background-color: #ff4c4c;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $first_name; ?>!</h1>
        <p><strong>Full Name:</strong> <?php echo $first_name . " " . $last_name; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Contact Number:</strong> <?php echo $contact_number; ?></p>
        <p><strong>Present Address:</strong> <?php echo $present_address; ?></p>
        <p><strong>Strand:</strong> <?php echo $strand; ?></p>
        <p><strong>Years of Enrollment:</strong> <?php echo $years_of_enrollment; ?></p>
        <p><strong>Current Status:</strong> <?php echo $current_status; ?></p>
        <p><strong>University/Employer:</strong> <?php echo $university_employer; ?></p>
        <p><strong>Position/Year Level:</strong> <?php echo $position_year_level; ?></p>
        <p><strong>Type of Employment:</strong> <?php echo $type_of_employment; ?></p>
        <p><strong>Year Hired:</strong> <?php echo $year_hired; ?></p>

        <a href="../../logout.php">Logout</a>
    </div>
</body>
</html>
