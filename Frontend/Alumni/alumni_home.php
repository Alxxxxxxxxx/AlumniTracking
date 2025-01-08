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

// Retrieve Work History from the database
$work_history_sql = "SELECT * FROM work_history WHERE alumni_email = ?";
$work_stmt = $conn->prepare($work_history_sql);
$work_stmt->bind_param("s", $user_identifier);
$work_stmt->execute();
$work_result = $work_stmt->get_result();
$work_history = [];
while ($work_row = $work_result->fetch_assoc()) {
    $work_history[] = $work_row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Dashboard</title>
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
            height: 100%;
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

        p {
            font-size: 1.2rem;
            color: #222222;
            font-family: 'Noticia Text', serif;
        }

        .btn-primary {
            font-family: 'Noticia Text', serif;
            background-color: #a00c30;
            border-color: #a00c30;
            margin: 3px;
        }

        .btn-primary:hover {
            font-family: 'Noticia Text', serif;
            background-color: #da1a32;
            border-color: #da1a32;
            margin: 3px;
        }

        .logout {
            display: block;
            text-align: center;
            color: #fafafa;
            background-color: #a00c30;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            font-family: 'Noticia Text', serif;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .logout:hover {
            background-color: #da1a32;
        }

        .work-history {
            margin-top: 30px;
        }

        .work-history table {
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img alt="jee" src="../../images/banner.png">
        </div>
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

        <!-- Work History Section -->
        <div class="work-history">
            <h3>Work History</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Position</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Job Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($work_history) > 0): ?>
                        <?php foreach ($work_history as $work): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($work['company_name']); ?></td>
                                <td><?php echo htmlspecialchars($work['position']); ?></td>
                                <td><?php echo htmlspecialchars($work['start_date']); ?></td>
                                <td><?php echo htmlspecialchars($work['end_date']); ?></td>
                                <td><?php echo htmlspecialchars($work['job_description']); ?></td>
                                <td><a href="edit_work_history.php?id=<?php echo $work['id']; ?>" class="btn btn-primary">Edit</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No work history available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <a href="add_work_history.php" class="btn btn-primary">Add Work History</a>
        <a href="../../logout.php" class="logout">Logout</a>
    </div>
</body>
</html>
