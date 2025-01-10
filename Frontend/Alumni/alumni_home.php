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
    $involvement = htmlspecialchars($row['involvement']);
    $academic_awards = htmlspecialchars($row['academic_awards']);
    $current_status = htmlspecialchars($row['current_status']);
    $university_employer = htmlspecialchars($row['university_employer']);
    $position_year_level = htmlspecialchars($row['position_year_level']);
    $type_of_employment = htmlspecialchars($row['type_of_employment']);
    $year_hired = htmlspecialchars($row['year_hired']);
} else {
    echo "User data not found.";
    exit();
}

// Update user data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updated_first_name = htmlspecialchars($_POST['first_name']);
    $updated_last_name = htmlspecialchars($_POST['last_name']);
    $updated_contact_number = htmlspecialchars($_POST['contact_number']);
    $updated_present_address = htmlspecialchars($_POST['present_address']);
    $updated_current_status = htmlspecialchars($_POST['current_status']);
    $updated_university_employer = htmlspecialchars($_POST['university_employer']);
    $updated_position_year_level = htmlspecialchars($_POST['position_year_level']);
    $updated_type_of_employment = htmlspecialchars($_POST['type_of_employment']);
    $updated_year_hired = htmlspecialchars($_POST['year_hired']);

    $update_sql = "UPDATE alumni SET 
        first_name = ?, 
        last_name = ?, 
        contact_number = ?, 
        present_address = ?, 
        current_status = ?, 
        university_employer = ?, 
        position_year_level = ?, 
        type_of_employment = ?, 
        year_hired = ? 
        WHERE email = ?";

    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param(
        "ssssssssis", 
        $updated_first_name, 
        $updated_last_name, 
        $updated_contact_number, 
        $updated_present_address, 
        $updated_current_status, 
        $updated_university_employer, 
        $updated_position_year_level, 
        $updated_type_of_employment, 
        $updated_year_hired, 
        $user_identifier
    );

    if ($update_stmt->execute()) {
        header("Location: alumni_home.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
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
            padding-bottom: 10px; 
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

        @media only screen and (max-width: 600px) {
            .adminTab{
                display: flex;
                width: 50%;
            }
            .filters {
                margin-bottom: 10px;
                display: flex;
                flex-wrap: wrap;
            }
            .filterSelect{
                width: 48%
            }

            .updateBtn{
                width: 100%
            }

            .logoutBtn{
                width: 100%
            }


        }
        </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome, <?php echo $first_name; ?>!</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $first_name; ?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $last_name; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email (Non-Editable)</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="contact_number" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo $contact_number; ?>" required>
            </div>
            <div class="mb-3">
                <label for="present_address" class="form-label">Present Address</label>
                <input type="text" class="form-control" id="present_address" name="present_address" value="<?php echo $present_address; ?>" required>
            </div>
            <div class="mb-3">
                <label for="strand" class="form-label">Strand (Non-Editable)</label>
                <input type="text" class="form-control" id="strand" name="strand" value="<?php echo $strand; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="years_of_enrollment" class="form-label">Years of Enrollment (Non-Editable)</label>
                <input type="text" class="form-control" id="years_of_enrollment" name="years_of_enrollment" value="<?php echo $years_of_enrollment; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="involvement" class="form-label">Involvement (Non-Editable)</label>
                <input type="text" class="form-control" id="involvement" name="involvement" value="<?php echo $involvement; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="academic_awards" class="form-label">Academic Awards (Non-Editable)</label>
                <input type="text" class="form-control" id="academic_awards" name="academic_awards" value="<?php echo $academic_awards; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="current_status" class="form-label">Current Status</label>
                <select name="current_status" id="current_status" class="form-select" required>
                    <option value="Secondary Student" <?php echo ($current_status == 'Secondary Student') ? 'selected' : ''; ?>>Secondary Student</option>
                    <option value="Tertiary Student" <?php echo ($current_status == 'Tertiary Student') ? 'selected' : ''; ?>>Tertiary Student</option>
                    <option value="Graduate School" <?php echo ($current_status == 'Graduate School') ? 'selected' : ''; ?>>Graduate School</option>
                    <option value="Working Student" <?php echo ($current_status == 'Working Student') ? 'selected' : ''; ?>>Working Student</option>
                    <option value="Employed" <?php echo ($current_status == 'Employed') ? 'selected' : ''; ?>>Employed</option>
                    <option value="Self-Employed" <?php echo ($current_status == 'Self-Employed') ? 'selected' : ''; ?>>Self-Employed</option>
                    <option value="Not-Employed" <?php echo ($current_status == 'Not-Employed') ? 'selected' : ''; ?>>Not-Employed</option>
                </select>
            </div>

            <div id="university_details" class="mb-3">
                <label for="university_employer" class="form-label">Name of University / Business / Employer</label>
                <input type="text" name="university_employer" id="university_employer" class="form-control" value="<?php echo $university_employer; ?>">
            </div>

            <div id="position_details" class="mb-3">
                <label for="position_year_level" class="form-label">Position or Year Level</label>
                <input type="text" name="position_year_level" id="position_year_level" class="form-control" value="<?php echo $position_year_level; ?>">
            </div>

            <div id="sector_details" class="mb-3">
                <label for="sector" class="form-label">Sector</label>
                <select name="sector" id="sector" class="form-select">
                    <option value="Public">Public</option>
                    <option value="Private">Private</option>
                    <option value="Goverment">Goverment</option>
                    <option value="NGO">NGO</option>
                    <option value="Non-Profit">Non-Profit</option>
                </select>
            </div>

            <div id="employment_details" class="mb-3">
                <label for="type_of_employment" class="form-label">Type of Employment</label>
                <select name="type_of_employment" id="type_of_employment" class="form-select">
                    <option value="Full-time" <?php echo ($type_of_employment == 'Full-time') ? 'selected' : ''; ?>>Full-time</option>
                    <option value="Part-time" <?php echo ($type_of_employment == 'Part-time') ? 'selected' : ''; ?>>Part-time</option>
                    <option value="Intern" <?php echo ($type_of_employment == 'Intern') ? 'selected' : ''; ?>>Intern</option>
                </select>
            </div>

            <div id="year_details" class="mb-3">
                <label for="year_hired" class="form-label">Year Hired</label>
                <input type="number" name="year_hired" id="year_hired" class="form-control" value="<?php echo $year_hired; ?>">
            </div>

            <!-- AGREEMENT AND SUBMISSION -->
            <div class="mb-3 form-check">
                <input type="checkbox" name="confirm_data" id="confirm_data" class="form-check-input" required>
                <label for="confirm_data" class="form-check-label">I confirm that the data provided is accurate.</label>
            </div>

            <button type="submit" class="btn btn-primary updateBtn">Update</button>
        </form>
        <a href="../../logout.php" class="btn btn-danger mt-3 logoutBtn">Logout</a>
    </div>

        <script>
            // JavaScript to conditionally hide/show employment details based on current status
            document.getElementById('current_status').addEventListener('change', function() {
                var currentStatus = this.value;
                var employmentDetails = document.getElementById('employment_details');
                var yearDetails = document.getElementById('year_details');
                var univDetails = document.getElementById('university_details');
                var positionDetails = document.getElementById('position_details');
                var sectorDetails = document.getElementById('sector_details');
                
                // Hide employment details and year hired fields when certain statuses are selected
                if (currentStatus === 'Not-Employed') {
                    employmentDetails.style.display = 'none';
                    yearDetails.style.display = 'none';
                    univDetails.style.display = 'none';
                    positionDetails.style.display = 'none';
                    sectorDetails.style.display = 'none';
                } else if (currentStatus === 'Secondary Student' || currentStatus === 'Tertiary Student' || currentStatus === 'Graduate School') {
                    employmentDetails.style.display = 'none';
                    yearDetails.style.display = 'none';
                    univDetails.style.display = 'block';
                    positionDetails.style.display = 'block';
                    sectorDetails.style.display = 'block';
                } else {
                    employmentDetails.style.display = 'block';
                    yearDetails.style.display = 'block';
                }
            });

            // Trigger change event on page load to set initial visibility
            document.getElementById('current_status').dispatchEvent(new Event('change'));
        </script>
    </div>
</body>
</html>