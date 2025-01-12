<?php
session_start();


if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: LandingPage.php'); 
    exit();
}

include '../../Backend/db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = $conn->query("SELECT * FROM alumni WHERE id = $id");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Record not found.";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $last_name = $_POST['last_name'];
        $first_name = $_POST['first_name'];
        $middle_name = $_POST['middle_name'];
        $present_location = $_POST['present_location'];
        $present_address = $_POST['present_address'];
        $contact_number = $_POST['contact_number'];
        $strand = $_POST['strand'];
        $years_of_enrollment = $_POST['years_of_enrollment'];
        $involvement = $_POST['involvement'];
        $academic_awards = $_POST['academic_awards'];
        $current_status = $_POST['current_status'];
        $university_employer = $_POST['university_employer'];
        $position_year_level = $_POST['position_year_level'];
        $sector = $_POST['sector'];
        $type_of_employment = $_POST['type_of_employment'];
        $year_hired = $_POST['year_hired'];

        // Update query
        $update_sql = "UPDATE alumni SET 
                        last_name = '$last_name', first_name = '$first_name', middle_name = '$middle_name',
                        present_location = '$present_location', present_address = '$present_address', 
                        contact_number = '$contact_number', strand = '$strand', 
                        years_of_enrollment = '$years_of_enrollment', involvement = '$involvement',
                        academic_awards = '$academic_awards', current_status = '$current_status',
                        university_employer = '$university_employer', position_year_level = '$position_year_level',
                        sector = '$sector', type_of_employment = '$type_of_employment', year_hired = '$year_hired'
                        WHERE id = $id";

        if ($conn->query($update_sql) === TRUE) {
            header('Location: admin_dashboard.php');
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Alumni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            padding: 20px;
            box-shadow: -15px 0 20px rgba(0, 0, 0, 0.2), 15px 0 20px rgba(0, 0, 0, 0.2);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .btn-primary {
            background-color: #a00c30;
            border-color: #a00c30;
        }
        .btn-primary:hover {
            background-color: #da1a32;
            border-color: #da1a32;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Alumni Record</h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" name="last_name" value="<?= $row['last_name'] ?>" required>
            </div>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" name="first_name" value="<?= $row['first_name'] ?>" required>
            </div>
            <div class="form-group">
                <label for="middle_name">Middle Name:</label>
                <input type="text" class="form-control" name="middle_name" value="<?= $row['middle_name'] ?>" required>
            </div>
            <div class="form-group">
                <label for="present_location">Present Location:</label>
                <select name="present_location" class="form-select" required>
                    <option value="In the Philippines" <?= ($row['present_location'] == 'In the Philippines') ? 'selected' : ''; ?>>In the Philippines</option>
                    <option value="Foreign Country" <?= ($row['present_location'] == 'Foreign Country') ? 'selected' : ''; ?>>Foreign Country</option>
                </select>
            </div>
            <div class="form-group">
                <label for="present_address">Present Address:</label>
                <input type="text" class="form-control" name="present_address" value="<?= $row['present_address'] ?>" required>
            </div>
            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input type="text" class="form-control" name="contact_number" value="<?= $row['contact_number'] ?>" required>
            </div>
            <div class="form-group">
                <label for="strand">Strand:</label>
                <div>
                    <div class="form-check">
                        <input type="radio" name="strand" value="Humanities and Social Sciences" id="strand_humss" class="form-check-input" <?= ($row['strand'] == 'Humanities and Social Sciences') ? 'checked' : ''; ?> required>
                        <label for="strand_humss" class="form-check-label">Humanities and Social Sciences</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="strand" value="Science, Technology, Engineering, and Mathematics" id="strand_stem" class="form-check-input" <?= ($row['strand'] == 'Science, Technology, Engineering, and Mathematics') ? 'checked' : ''; ?> required>
                        <label for="strand_stem" class="form-check-label">Science, Technology, Engineering, and Mathematics</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="strand" value="Accountancy, Businesses, and Management" id="strand_abm" class="form-check-input" <?= ($row['strand'] == 'Accountancy, Businesses, and Management') ? 'checked' : ''; ?> required>
                        <label for="strand_abm" class="form-check-label">Accountancy, Businesses, and Management</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="strand" value="Information and Communication Technology" id="strand_ict" class="form-check-input" <?= ($row['strand'] == 'Information and Communication Technology') ? 'checked' : ''; ?> required>
                        <label for="strand_ict" class="form-check-label">Information and Communication Technology</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="strand" value="Food and Beverages" id="strand_food" class="form-check-input" <?= ($row['strand'] == 'Food and Beverages') ? 'checked' : ''; ?> required>
                        <label for="strand_food" class="form-check-label">Food and Beverages</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="strand" value="Others" id="strand_others" class="form-check-input" <?= ($row['strand'] == 'Others') ? 'checked' : ''; ?> required>
                        <label for="strand_others" class="form-check-label">Others</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="years_of_enrollment">Years of Enrollment:</label>
                <input type="text" class="form-control" name="years_of_enrollment" value="<?= $row['years_of_enrollment'] ?>" required>
            </div>
            <div class="form-group">
                <label for="involvement">Involvement:</label>
                <input type="text" class="form-control" name="involvement" value="<?= $row['involvement'] ?>" required>
            </div>
            <div class="form-group">
                <label for="academic_awards">Academic Awards:</label>
                <input type="text" class="form-control" name="academic_awards" value="<?= $row['academic_awards'] ?>" required>
            </div>
            <div class="form-group" id="current_status_wrapper">
                <label for="current_status">Current Status:</label>
                <select name="current_status" id="current_status" class="form-select" required>
                    <option value="Secondary Student" <?= ($row['current_status'] == 'Secondary Student') ? 'selected' : ''; ?>>Secondary Student</option>
                    <option value="Tertiary Student" <?= ($row['current_status'] == 'Tertiary Student') ? 'selected' : ''; ?>>Tertiary Student</option>
                    <option value="Graduate School" <?= ($row['current_status'] == 'Graduate School') ? 'selected' : ''; ?>>Graduate School</option>
                    <option value="Working Student" <?= ($row['current_status'] == 'Working Student') ? 'selected' : ''; ?>>Working Student</option>
                    <option value="Employed" <?= ($row['current_status'] == 'Employed') ? 'selected' : ''; ?>>Employed</option>
                    <option value="Self-Employed" <?= ($row['current_status'] == 'Self-Employed') ? 'selected' : ''; ?>>Self-Employed</option>
                    <option value="Not-Employed" <?= ($row['current_status'] == 'Not-Employed') ? 'selected' : ''; ?>>Not-Employed</option>
                </select>
            </div>

            <div class="form-group" id="university_details" style="display: none;">
                <label for="university_employer">University / Employer:</label>
                <input type="text" class="form-control" name="university_employer" id="university_employer" value="<?= $row['university_employer'] ?>">
            </div>

            <div class="form-group" id="position_details" style="display: none;">
                <label for="position_year_level">Position / Year Level:</label>
                <input type="text" class="form-control" name="position_year_level" id="position_year_level" value="<?= $row['position_year_level'] ?>">
            </div>

            <div class="form-group" id="sector_details" style="display: none;">
                <label for="sector">Sector:</label>
                <select name="sector" id="sector" class="form-select">
                    <option value="Public" <?= ($row['sector'] == 'Public') ? 'selected' : ''; ?>>Public</option>
                    <option value="Private" <?= ($row['sector'] == 'Private') ? 'selected' : ''; ?>>Private</option>
                    <option value="Goverment" <?= ($row['sector'] == 'Goverment') ? 'selected' : ''; ?>>Goverment</option>
                    <option value="NGO" <?= ($row['sector'] == 'NGO') ? 'selected' : ''; ?>>NGO</option>
                    <option value="Non-Profit" <?= ($row['sector'] == 'Non-Profit') ? 'selected' : ''; ?>>Non-Profit</option>
                </select>
            </div>

            <div class="form-group" id="employment_details" style="display: none;">
                <label for="type_of_employment">Type of Employment:</label>
                <select name="type_of_employment" id="type_of_employment" class="form-select">
                    <option value="Full-time" <?= ($row['type_of_employment'] == 'Full-time') ? 'selected' : ''; ?>>Full-time</option>
                    <option value="Part-time" <?= ($row['type_of_employment'] == 'Part-time') ? 'selected' : ''; ?>>Part-time</option>
                    <option value="Intern" <?= ($row['type_of_employment'] == 'Intern') ? 'selected' : ''; ?>>Intern</option>
                </select>
            </div>

            <div class="form-group" id="year_details" style="display: none;">
                <label for="year_hired">Year Hired:</label>
                <input type="text" class="form-control" name="year_hired" id="year_hired" value="<?= $row['year_hired'] ?>">
            </div>

            <button type="submit" class="btn btn-primary">Update Record</button>

        </form>
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
</body>
</html>
