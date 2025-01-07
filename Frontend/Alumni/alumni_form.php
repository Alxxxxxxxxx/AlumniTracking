<?php
session_start();
include('../../Backend/db_connect.php');

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'alumni') {
    // User is logged in as alumni
    $alumniInfo = $_SESSION['user'];  // Access session data
    $user_identifier = $alumniInfo['email']; // Use email as unique identifier
} else {
    echo "User not logged in.";
    exit();
}

// Retrieve the alumni data from the database based on the email
$sql = "SELECT * FROM alumni WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_identifier);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Pre-fill the form with the user's data
    $email = $row['email'];
    $last_name = $row['last_name'];
    $first_name = $row['first_name'];
    $middle_name = $row['middle_name'];
    $present_location = $row['present_location'];
    $present_address = $row['present_address'];
    $contact_number = $row['contact_number'];
    $strand = $row['strand'];
    $years_of_enrollment = $row['years_of_enrollment'];
    $involvement = $row['involvement'];
    $academic_awards = $row['academic_awards'];
    $current_status = $row['current_status'];
    $university_employer = $row['university_employer'];
    $position_year_level = $row['position_year_level'];
    $sector = $row['sector'];
    $type_of_employment = $row['type_of_employment'];
    $year_hired = $row['year_hired'];
    $privacy_consent = $row['privacy_consent'];
    $confirm_data = $row['confirm_data'];
} else {
    echo "User not found.";
    exit();  // Stop the script if no matching user is found
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $privacy_consent = isset($_POST['privacy_consent']) ? 1 : 0;
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $middle_name = $conn->real_escape_string($_POST['middle_name']);
    $present_location = $conn->real_escape_string($_POST['present_location']);
    $present_address = $conn->real_escape_string($_POST['present_address']);
    $contact_number = $conn->real_escape_string($_POST['contact_number']);
    $strand = $conn->real_escape_string($_POST['strand']);
    $years_of_enrollment = $conn->real_escape_string($_POST['years_of_enrollment']);
    $involvement = $conn->real_escape_string($_POST['involvement']);
    $academic_awards = $conn->real_escape_string($_POST['academic_awards']);
    $current_status = $conn->real_escape_string($_POST['current_status']);
    $university_employer = $conn->real_escape_string($_POST['university_employer']);
    $position_year_level = $conn->real_escape_string($_POST['position_year_level']);
    $sector = $conn->real_escape_string($_POST['sector']);
    $type_of_employment = $conn->real_escape_string($_POST['type_of_employment']);
    $year_hired = $conn->real_escape_string($_POST['year_hired']);
    $confirm_data = isset($_POST['confirm_data']) ? 1 : 0;

    // Update the data in the database
    $sql = "UPDATE alumni SET
        privacy_consent = $privacy_consent, last_name = '$last_name', first_name = '$first_name', middle_name = '$middle_name',
        present_location = '$present_location', present_address = '$present_address', contact_number = '$contact_number', strand = '$strand',
        years_of_enrollment = '$years_of_enrollment', involvement = '$involvement', academic_awards = '$academic_awards',
        current_status = '$current_status', university_employer = '$university_employer', position_year_level = '$position_year_level',
        sector = '$sector', type_of_employment = '$type_of_employment', year_hired = '$year_hired', confirm_data = $confirm_data
        WHERE email = '$email'";

    if ($conn->query($sql) === TRUE) {
        // Display a success message and redirect after 1 second
        echo "<script>
                alert('Data successfully updated!');
                setTimeout(function() {
                    window.location.href = '../login.php'; // Redirect to the login page
                }, 1000); // 1000ms = 1 second
            </script>";
    } else {
        // Display an error message with popup and no redirection
        echo "<script>
                alert('Error: " . $conn->error . "');
            </script>";
    }

}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2 class="mb-4 text-center">Alumni Registration</h2>
    <p class="text-center">
        Rest assured that your information for this questionnaire will be treated with confidentiality.
        <br><small>*Add Data Privacy Act and Terms & Conditions</small>
    </p>
    <form action="" method="POST">
        <!-- PART 1: PERSONAL INFORMATION -->
        <h4 class="mb-3">Personal Information</h4>
        <p>Be reminded that if no answers are applicable, write or choose "N/A.”.</p>

        <!-- Display Email -->
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
        <h4 class="mb-3">Strand and Graduation Year</h4>
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
        <h4 class="mb-3">Connection to Sacred Heart of Jesus Catholic School</h4>
        <div class="mb-3">
            <label for="involvement" class="form-label">Involvement</label>
            <input type="text" name="involvement" id="involvement" class="form-control" value="<?php echo $involvement; ?>" placeholder="Ex. SC President 2024-2025" required>
        </div>
        <div class="mb-3">
            <label for="academic_awards" class="form-label">Graduation Academic Awards</label>
            <input type="text" name="academic_awards" id="academic_awards" class="form-control" value="<?php echo $academic_awards; ?>" placeholder="Ex. With Honors, Valedictorian (2025)" required>
        </div>

        <!-- PART 4: EMPLOYMENT -->
        <h4 class="mb-3">Employment</h4>
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
        <div class="mb-3">
            <label for="university_employer" class="form-label">Name of University / Business / Employer</label>
            <input type="text" name="university_employer" id="university_employer" class="form-control" value="<?php echo $university_employer; ?>" required>
        </div>
        <div class="mb-3">
            <label for="position_year_level" class="form-label">Position or Year Level</label>
            <input type="text" name="position_year_level" id="position_year_level" class="form-control" value="<?php echo $position_year_level; ?>" required>
        </div>
        <div class="mb-3">
            <label for="sector" class="form-label">Sector</label>
            <select name="sector" id="sector" class="form-select" required>
                <option value="Public" <?php echo ($sector == 'Public') ? 'selected' : ''; ?>>Public</option>
                <option value="Private" <?php echo ($sector == 'Private') ? 'selected' : ''; ?>>Private</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="type_of_employment" class="form-label">Type of Employment</label>
            <select name="type_of_employment" id="type_of_employment" class="form-select" required>
                <option value="Full-time" <?php echo ($type_of_employment == 'Full-time') ? 'selected' : ''; ?>>Full-time</option>
                <option value="Part-time" <?php echo ($type_of_employment == 'Part-time') ? 'selected' : ''; ?>>Part-time</option>
                <option value="Intern" <?php echo ($type_of_employment == 'Intern') ? 'selected' : ''; ?>>Intern</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="year_hired" class="form-label">Year Hired</label>
            <input type="number" name="year_hired" id="year_hired" class="form-control" value="<?php echo $year_hired; ?>" required>
        </div>

        <!-- AGREEMENT AND SUBMISSION -->
        <div class="mb-3 form-check">
            <input type="checkbox" name="confirm_data" id="confirm_data" class="form-check-input" <?php echo ($confirm_data == 1) ? 'checked' : ''; ?> required>
            <label for="confirm_data" class="form-check-label">I confirm that the data provided is accurate.</label>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
