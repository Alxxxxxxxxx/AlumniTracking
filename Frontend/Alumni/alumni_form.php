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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
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
            z-index: -1;
            box-shadow: -15px 0 20px rgba(0, 0, 0, 0.2), 15px 0 20px rgba(0, 0, 0, 0.2);
            padding-left: 20px; 
            padding-right: 20px; 
        }

        h1 {
            padding-top: 40px;
            font-size: 3rem;
            color: #a00c30;
            text-align: center;
            font-family: 'Shrikhand', sans-serif;
        }

        h3 {
            font-size: 1.1rem;
            color: #222222;
            font-family: 'Noticia Text', serif;
            margin-bottom: 40px;
        }

        h4 {
            font-size: 1.5rem;
            color: #a00c30;
            font-family: 'Noticia Text', serif;
            font-weight: bolder;
            margin-bottom: 40px;
        }

        p {
            font-size: 1rem;
            color: #222222;
            font-family: 'Noticia Text', serif;
            margin-bottom: 40px;
        }

        label {
            font-size: 1rem;
            color: #222222;
        }

        .btn-primary{
            font-family: 'Noticia Text', serif;
            background-color: #a00c30;
            border-color: #a00c30;
            margin-bottom: 50px;
        }

        .btn-primary:hover{
            font-family: 'Noticia Text', serif;
            background-color: #da1a32;
            border-color: #da1a32;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            appearance: none;
            background-color: #fff;
            border: 2px solid #333;
            border-radius: 1px;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #da1a32; 
            border-color: #da1a32;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }

        .modal-header {
            background-color: #a00c30;
            color: white;
            padding: 10px;
            font-size: 1.2rem;
        }

        .modal-body {
            padding: 20px;
            font-size: 1.1rem;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="mb-4 text-center"> Alumni Registration </h1>
    <h3 class="text-center">
        Rest assured that your information for this questionnaire will be treated with confidentiality.
        <br><small>*Add Data Privacy Act and Terms & Conditions</small>
    </h3>
    <form action="" method="POST">
        <!-- PART 1: PERSONAL INFORMATION -->
        <h4 class="mb-3">‣ Personal Information</h4>
        <p>Be reminded that if no answers are applicable, write or choose "N/A.”.</p>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input class="form-control" value="<?php echo $email; ?>" disabled>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="privacy_consent" id="privacy_consent" class="form-check-input" <?php echo ($privacy_consent == 1) ? 'checked' : ''; ?> required>
            <label for="privacy_consent" class="form-check-label">
                I have read and understood the information and details provided by the research. I, therefore, give consent to participate in this study.
            </label>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $last_name; ?>" required>
        </div>
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $first_name; ?>" required>
        </div>
        <div class="mb-3">
            <label for="middle_name" class="form-label">Middle Name</label>
            <input type="text" name="middle_name" id="middle_name" class="form-control" value="<?php echo $middle_name; ?>">
        </div>
        <div class="mb-3">
            <label for="present_location" class="form-label">Present Location</label>
            <select name="present_location" id="present_location" class="form-select" required>
                <option value="In the Philippines" <?php echo ($present_location == 'In the Philippines') ? 'selected' : ''; ?>>In the Philippines</option>
                <option value="Foreign Country" <?php echo ($present_location == 'Foreign Country') ? 'selected' : ''; ?>>Foreign Country</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="present_address" class="form-label">Present Address</label>
            <input type="text" name="present_address" id="present_address" class="form-control" value="<?php echo $present_address; ?>" placeholder="Ex. Sta. Mesa, Manila, Philippines" required>
        </div>
        <div class="mb-3">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="text" name="contact_number" id="contact_number" class="form-control" value="<?php echo $contact_number; ?>" required>
        </div>

        <!-- PART 2: STRAND AND GRADUATION YEAR -->
        <h4 class="mb-3">‣ Strand and Graduation Year</h4>
        <div class="mb-3">
            <label class="form-label">Strand</label>
            <div>
                <div class="form-check">
                    <input type="radio" name="strand" value="Humanities and Social Sciences" id="strand_humss" class="form-check-input" <?php echo ($strand == 'Humanities and Social Sciences') ? 'checked' : ''; ?> required>
                    <label for="strand_humss" class="form-check-label">Humanities and Social Sciences</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="strand" value="Science, Technology, Engineering, and Mathematics" id="strand_stem" class="form-check-input" <?php echo ($strand == 'Science, Technology, Engineering, and Mathematics') ? 'checked' : ''; ?> required>
                    <label for="strand_stem" class="form-check-label">Science, Technology, Engineering, and Mathematics</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="strand" value="Accountancy, Businesses, and Management" id="strand_abm" class="form-check-input" <?php echo ($strand == 'Accountancy, Businesses, and Management') ? 'checked' : ''; ?> required>
                    <label for="strand_abm" class="form-check-label">Accountancy, Businesses, and Management</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="strand" value="Information and Communication Technology" id="strand_ict" class="form-check-input" <?php echo ($strand == 'Information and Communication Technology') ? 'checked' : ''; ?> required>
                    <label for="strand_ict" class="form-check-label">Information and Communication Technology</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="strand" value="Food and Beverages" id="strand_food" class="form-check-input" <?php echo ($strand == 'Food and Beverages') ? 'checked' : ''; ?> required>
                    <label for="strand_food" class="form-check-label">Food and Beverages</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="strand" value="Others" id="strand_others" class="form-check-input" <?php echo ($strand == 'Others') ? 'checked' : ''; ?> required>
                    <label for="strand_others" class="form-check-label">Others</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="years_of_enrollment" class="form-label">Years of Enrollment</label>
            <input type="text" name="years_of_enrollment" id="years_of_enrollment" class="form-control" value="<?php echo $years_of_enrollment; ?>" placeholder="Ex. 2020 - 2024" required>
        </div>

        <!-- PART 3: CONNECTION TO SCHOOL -->
        <h4 class="mb-3">‣ Connection to Sacred Heart of Jesus Catholic School</h4>
        <div class="mb-3">
            <label for="involvement" class="form-label">Involvement</label>
            <input type="text" name="involvement" id="involvement" class="form-control" value="<?php echo $involvement; ?>" placeholder="Ex. SC President 2024-2025" required>
        </div>
        <div class="mb-3">
            <label for="academic_awards" class="form-label">Graduation Academic Awards</label>
            <input type="text" name="academic_awards" id="academic_awards" class="form-control" value="<?php echo $academic_awards; ?>" placeholder="Ex. With Honors, Valedictorian (2025)" required>
        </div>

        <!-- PART 4: EMPLOYMENT -->
        <h4 class="mb-3">‣ Employment</h4>
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
            <input type="text" name="university_employer" id="university_employer" class="form-control" value="<?php echo $university_employer; ?>" >
        </div>
        <div id="position_details" class="mb-3">
            <label for="position_year_level" class="form-label">Position or Year Level</label>
            <input type="text" name="position_year_level" id="position_year_level" class="form-control" value="<?php echo $position_year_level; ?>" >
        </div>
        <div id="sector_details" class="mb-3">
            <label for="sector" class="form-label">Sector</label>
            <select name="sector" id="sector" class="form-select" >
                <option value="Public" <?php echo ($sector == 'Public') ? 'selected' : ''; ?>>Public</option>
                <option value="Private" <?php echo ($sector == 'Private') ? 'selected' : ''; ?>>Private</option>
            </select>
        </div>

        <!-- Conditional Fields: Type of Employment and Year Hired -->
        <div id="employment_details" class="mb-3">
            <label for="type_of_employment" class="form-label">Type of Employment</label>
            <select name="type_of_employment" id="type_of_employment" class="form-select" >
                <option value="Full-time" <?php echo ($type_of_employment == 'Full-time') ? 'selected' : ''; ?>>Full-time</option>
                <option value="Part-time" <?php echo ($type_of_employment == 'Part-time') ? 'selected' : ''; ?>>Part-time</option>
                <option value="Intern" <?php echo ($type_of_employment == 'Intern') ? 'selected' : ''; ?>>Intern</option>
            </select>
        </div>
        <div id="year_details" class="mb-3">
            <label for="year_hired" class="form-label">Year Hired</label>
            <input type="number" name="year_hired" id="year_hired" class="form-control" value="<?php echo $year_hired; ?>" >
        </div>

        <!-- AGREEMENT AND SUBMISSION -->
        <div class="mb-3 form-check">
            <input type="checkbox" name="confirm_data" id="confirm_data" class="form-check-input" <?php echo ($confirm_data == 1) ? 'checked' : ''; ?> >
            <label for="confirm_data" class="form-check-label">I confirm that the data provided is accurate.</label>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>

        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Success</h5>
                    </div>
                    <div class="modal-body">
                        Data Successfully Received.
                    </div>
                </div>
            </div>
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
                    // Only show "Current Status" and hide the rest
                    employmentDetails.style.display = 'none';
                    yearDetails.style.display = 'none';
                    univDetails.style.display = 'none';
                    positionDetails.style.display = 'none';
                    sectorDetails.style.display = 'none';
                } else if (currentStatus === 'Secondary Student' || currentStatus === 'Tertiary Student' || currentStatus === 'Graduate School') {
                    // Hide employment details and year hired for students, but show other parts
                    employmentDetails.style.display = 'none';
                    yearDetails.style.display = 'none';
                    univDetails.style.display = 'block';
                    positionDetails.style.display = 'block';
                    sectorDetails.style.display = 'block';
                } else {
                    // Show employment details and year hired when employed or self-employed
                    employmentDetails.style.display = 'block';
                    yearDetails.style.display = 'block';
                }
            });

            // Trigger change event on page load to set initial visibility
            document.getElementById('current_status').dispatchEvent(new Event('change'));
        </script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
