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

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the alumni data from the database
$sql = "SELECT * FROM alumni WHERE email = ?";
$stmt = $conn->prepare($sql);

// Check if the SQL query was prepared successfully
if ($stmt === false) {
    die("Error preparing SQL query: " . $conn->error);
}

$stmt->bind_param("s", $user_identifier);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $first_name = htmlspecialchars($row['first_name']);
    $middle_name = htmlspecialchars($row['middle_name']);
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
    $privacy_consent = htmlspecialchars($row['privacy_consent']); 
    $sector = htmlspecialchars($row['sector']);
    $confirm_data = htmlspecialchars_decode($row['confirm_data']);
    
} else {
    echo "User data not found.";
    exit();
}

// Update user data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updated_first_name = htmlspecialchars($_POST['first_name']);
    $updated_middle_name = htmlspecialchars($_POST['middle_name']);
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
    $updated_strand = htmlspecialchars($_POST['strand']);
    $updated_years_of_enrollment = htmlspecialchars($_POST['years_of_enrollment']);
    $updated_involvement = htmlspecialchars($_POST['involvement']);
    $updated_academic_awards = htmlspecialchars($_POST['academic_awards']);
    $updated_privacy_consent = htmlspecialchars($_POST['privacy_consent']);
    $updated_sector = htmlspecialchars($_POST['sector']);
    $updated_confirm_data = htmlspecialchars_decode($_POST['confirm_data']);

    // Simplified SQL query for update
    $update_sql = "UPDATE alumni SET 
        first_name = ?, 
        middle_name = ?, 
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
        strand = ?, 
        years_of_enrollment = ?, 
        involvement = ?, 
        academic_awards = ?, 
        privacy_consent = ?, 
        sector = ?, 
        confirm_data = ? 
        WHERE email = ?";

    $update_stmt = $conn->prepare($update_sql);

    if ($update_stmt === false) {
        die("Error preparing the update SQL query: " . $conn->error);
    }

    $update_stmt->bind_param(
        "ssssssssssssssssssss", 
        $updated_first_name, 
        $updated_middle_name, 
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
        $updated_strand, 
        $updated_years_of_enrollment, 
        $updated_involvement, 
        $updated_academic_awards, 
        $updated_privacy_consent, 
        $updated_sector,
        $updated_confirm_data,
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
    <link rel="icon" href="../../images/logo.ico" type="image/logo">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noticia+Text&display=swap" rel="stylesheet">
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
        .container h3 {
            font-size: 1.3rem;
            margin-top: -20px;
            margin-bottom: 20px;
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
            border-color:rgb(0, 0, 0);
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
    </h3>
    <form action="" method="POST">
        <!-- PART 1: PERSONAL INFORMATION -->
        <h4 class="mb-3">‣ Personal Information</h4>
        <p>Be reminded that if no answers are applicable, write or choose "N/A.”.</p>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input class="form-control" value="<?php echo $email; ?>" disabled>
        </div>

       <!-- Checkbox for Terms and Conditions -->
       <div class="form-check mb-3">
            <input type="checkbox" name="privacy_consent" id="privacy_consent" class="form-check-input" required>
            <label for="privacy_consent" class="form-check-label" style="font-size: 16px; color: #000000;">
                I have read, understood, and agree to the Terms and Conditions.
            </label>
        </div>


        <!-- Modal for Terms and Conditions -->
        <div class="modal fade" id="terms-modal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="termsModalLabel" style="color: #000000;">Terms and Conditions</h5>
                        <!-- X button for closing -->
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="max-height: 60vh; overflow-y: auto; text-align: left; padding-left: 20px; text-align: justify; font-size: 14px; line-height: 1.5; color: #000000;">
                        <p><strong>DATA PRIVACY ACT</strong><br>
                            The alumni tracking system is committed to safeguarding the personal data of its users in strict compliance with the Data Privacy Act of 2012 (RA 10173). All information provided will be processed fairly, lawfully, and transparently, ensuring confidentiality and integrity. We sincerely value your security and respect your data privacy. Personal information will not be shared with third parties without explicit consent, except as required by law or with the approval of the school administration. Proper security protocols will be employed to prevent unauthorized access, disclosure, or alteration of personal data.
                        </p>
                        <p><strong>TERMS AND CONDITIONS</strong></p>
                        <ul>
                            <li><strong>Acceptance of Terms:</strong> By accessing and completing this alumni tracker questionnaire, you acknowledge that you have read, understood, and agreed to be bound by these terms and conditions. If you do not agree with any part of these terms, please do not participate in this questionnaire.</li>
                            <li><strong>Purpose of The Alumni Tracker:</strong> The alumni tracker aims to collect information to maintain a comprehensive database of the school’s graduates for administrative, networking, and research purposes.</li>
                            <li><strong>Potential Use for Research:</strong> With approval from the school’s administrators, the alumni tracking system may be utilized for future research. Researchers may request access to the system to identify potential respondents if deemed necessary and approved by the school’s administration.</li>
                            <li><strong>Potential Use for Networking:</strong> The tracker may be a point of contact for the school to reach out to alumni for future programs, events, or initiatives.</li>
                            <li><strong>User Responsibilities:</strong> Participants agree to provide accurate and truthful information and respect the confidentiality of the alumni tracker.</li>
                            <li><strong>Prohibited Activities:</strong> Participants must not submit false information or breach system security.</li>
                            <li><strong>Limitation of Liability:</strong> The school is not liable for indirect or consequential damages or unauthorized access to data beyond its control.</li>
                            <li><strong>Data Privacy and Confidentiality:</strong> Information will be stored securely and used solely for the purposes outlined.</li>
                            <li><strong>Amendments to Terms:</strong> The school may update these terms, and continued use constitutes acceptance of any revisions.</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="accept-terms" class="btn btn-primary">Accept</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var termsCheckbox = document.getElementById('privacy_consent');
                var termsModal = new bootstrap.Modal(document.getElementById('terms-modal'));
                var acceptButton = document.getElementById('accept-terms');

                termsCheckbox.addEventListener('click', function (event) {
                    if (!termsCheckbox.checked) {
                        
                    } else {
                        termsCheckbox.checked = false;
                        termsModal.show();
                    }
                });

                acceptButton.addEventListener('click', function () {
                    termsCheckbox.checked = true; 
                    termsModal.hide(); 
                });
            });


        </script>


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
                <option value="" disabled selected>Choose Your Location</option> 
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
        <div class="form-group">
                <label for="fb_account">Facebook Account:</label>
                <input type="text" class="form-control" name="fb_account" value="<?= $row['fb_account'] ?>" required>
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
                <option value="" disabled selected>Choose Your Current Status</option>
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
                <option value="Public" <?php echo ($sector == 'Public') ? 'selected' : ''; ?>>Public</option>
                <option value="Private" <?php echo ($sector == 'Private') ? 'selected' : ''; ?>>Private</option>
                <option value="Government" <?php echo ($sector == 'Government') ? 'selected' : ''; ?>>Government</option>
                <option value="NGO" <?php echo ($sector == 'NGO') ? 'selected' : ''; ?>>NGO</option>
                <option value="Non-Profit" <?php echo ($sector == 'Non-Profit') ? 'selected' : ''; ?>>Non-Profit</option>
            </select>
        </div>

        <!-- Conditional Fields: Type of Employment and Year Hired -->
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
            <input type="checkbox" name="confirm_data" id="confirm_data" class="form-check-input" <?php echo ($confirm_data == 1) ? 'checked' : ''; ?> required>
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

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
