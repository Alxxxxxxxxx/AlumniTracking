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
    $fb_account = htmlspecialchars($row['fb_account']);
    $present_location = htmlspecialchars($row['present_location']);
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
    $finish_course = htmlspecialchars($row['finish_course']);
    $alumni_feedback = htmlspecialchars($row['alumni_feedback']);
} else {
    echo "User data not found.";
    exit();
}

// Update user data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updated_first_name = htmlspecialchars($_POST['first_name']);
    $updated_last_name = htmlspecialchars($_POST['last_name']);
    $updated_contact_number = htmlspecialchars($_POST['contact_number']);
    $updated_fb_account = htmlspecialchars($_POST['fb_account']);
    $updated_present_location = htmlspecialchars($_POST['present_location']);
    $updated_present_address = htmlspecialchars($_POST['present_address']);
    $updated_current_status = htmlspecialchars($_POST['current_status']);
    $updated_university_employer = htmlspecialchars($_POST['university_employer']);
    $updated_position_year_level = htmlspecialchars($_POST['position_year_level']);
    $updated_type_of_employment = htmlspecialchars($_POST['type_of_employment']);
    $updated_year_hired = htmlspecialchars($_POST['year_hired']);
    $updated_finish_course = htmlspecialchars($_POST['finish_course']);
    $updated_alumni_feedback = htmlspecialchars($_POST['alumni_feedback']);

    $update_sql = "UPDATE alumni SET 
        first_name = ?, 
        last_name = ?, 
        contact_number = ?, 
        fb_account = ?,
        present_location = ?,
        present_address = ?, 
        current_status = ?, 
        university_employer = ?, 
        position_year_level = ?, 
        type_of_employment = ?, 
        year_hired = ?,
        finish_course = ?,
        alumni_feedback = ?
    WHERE email = ?";


    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param(
        "ssssssssisssss", 
        $updated_first_name, 
        $updated_last_name, 
        $updated_contact_number, 
        $updated_fb_account,
        $updated_present_location,
        $updated_present_address, 
        $updated_current_status, 
        $updated_university_employer, 
        $updated_position_year_level, 
        $updated_type_of_employment, 
        $updated_year_hired,
        $updated_finish_course,
        $updated_alumni_feedback,
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
            <div class="form-group">
                <label for="fb_account">Facebook Account:</label>
                <input type="text" class="form-control" name="fb_account" value="<?= $row['fb_account'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="present_location" class="form-label">Present Location</label>
                <select name="present_location" id="present_location" class="form-select" required>
                    <option value="In the Philippines" <?= ($present_location == 'In the Philippines') ? 'selected' : ''; ?>>In the Philippines</option>
                    <option value="Foreign Country" <?= ($present_location == 'Foreign Country') ? 'selected' : ''; ?>>Foreign Country</option>
                </select>
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
                <label for="years_of_enrollment" class="form-label">Years of Tenure (Non-Editable)</label>
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

            <div class="form-group">
                <label for="alumni_feedback">Alumni Feedback:</label>
                <input type="text" class="form-control" name="alumni_feedback" value="<?= $row['alumni_feedback'] ?>" required>
            </div>

            <div class="form-group">
                <label for="finish_course">Finish Course:</label>
                <input type="text" class="form-control" name="finish_course" value="<?= $row['finish_course'] ?>" required>
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
            document.addEventListener('DOMContentLoaded', function () {
                const currentStatus = document.getElementById('current_status');
                const employmentDetails = document.getElementById('employment_details');
                const yearDetails = document.getElementById('year_details');
                const univDetails = document.getElementById('university_details');
                const positionDetails = document.getElementById('position_details');
                const sectorDetails = document.getElementById('sector_details');
                const typeOfEmployment = document.getElementById('type_of_employment');
                const yearHired = document.getElementById('year_hired');
                const universityEmployer = document.getElementById('university_employer');
                const positionYearLevel = document.getElementById('position_year_level');
                const sector = document.getElementById('sector');

                function toggleSections(status) {
                    // Hide all sections and remove "required" attributes
                    employmentDetails.style.display = 'none';
                    yearDetails.style.display = 'none';
                    univDetails.style.display = 'none';
                    positionDetails.style.display = 'none';
                    sectorDetails.style.display = 'none';

                    typeOfEmployment.removeAttribute('required');
                    yearHired.removeAttribute('required');
                    universityEmployer.removeAttribute('required');
                    positionYearLevel.removeAttribute('required');
                    sector.removeAttribute('required');

                    if (status === 'Secondary Student' || status === 'Tertiary Student' || status === 'Graduate School') {
                        univDetails.style.display = 'block';
                        positionDetails.style.display = 'block';
                        sectorDetails.style.display = 'block';

                        universityEmployer.setAttribute('required', 'required');
                        positionYearLevel.setAttribute('required', 'required');
                        sector.setAttribute('required', 'required');
                    } else if (status === 'Working Student' || status === 'Employed' || status === 'Self-Employed') {
                        univDetails.style.display = 'block';
                        employmentDetails.style.display = 'block';
                        yearDetails.style.display = 'block';
                        positionDetails.style.display = 'block';
                        sectorDetails.style.display = 'block';

                        typeOfEmployment.setAttribute('required', 'required');
                        yearHired.setAttribute('required', 'required');
                        universityEmployer.setAttribute('required', 'required');
                        positionYearLevel.setAttribute('required', 'required');
                        sector.setAttribute('required', 'required');
                    }

                    if (status === 'Not-Employed') {
                        typeOfEmployment.value = "";
                        yearHired.value = "";
                        universityEmployer.value = "";
                        positionYearLevel.value = "";
                        sector.value = "";
                    } else if (status === 'Secondary Student' || status === 'Tertiary Student' || status === 'Graduate School') {  
                        typeOfEmployment.value = "";
                        yearHired.value = "";
                    } else if (status === 'Working Student' || status === 'Employed' || status === 'Self-Employed') {
                    
                    }
                }

                toggleSections(currentStatus.value);

                currentStatus.addEventListener('change', function () {
                    toggleSections(this.value);
                });
            });


        </script>
    </div>
</body>
</html>