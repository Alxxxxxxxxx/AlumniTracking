<?php

$host = 'localhost';
$username = 'root'; 
$password = '';     
$database = 'school_alumni';

$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $email = $conn->real_escape_string($_POST['email']);
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

   
    $sql = "INSERT INTO tables (
        email, privacy_consent, last_name, first_name, middle_name,
        present_location, present_address, contact_number, strand, years_of_enrollment,
        involvement, academic_awards, current_status, university_employer,
        position_year_level, sector, type_of_employment, year_hired, confirm_data
    ) VALUES (
        '$email', $privacy_consent, '$last_name', '$first_name', '$middle_name',
        '$present_location', '$present_address', '$contact_number', '$strand', '$years_of_enrollment',
        '$involvement', '$academic_awards', '$current_status', '$university_employer',
        '$position_year_level', '$sector', '$type_of_employment', '$year_hired', $confirm_data
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Data successfully submitted! <a href='form.php'>Go Back</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
