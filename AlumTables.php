<?php

$host = 'localhost';
$username = 'root'; 
$password = '';     
$database = 'school_alumni';

$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM alumni";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tables</title>
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">Submitted Data</h2>
        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Privacy Consent</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Present Location</th>
                            <th>Present Address</th>
                            <th>Contact Number</th>
                            <th>Strand</th>
                            <th>Years of Enrollment</th>
                            <th>Involvement</th>
                            <th>Academic Awards</th>
                            <th>Current Status</th>
                            <th>University / Employer</th>
                            <th>Position / Year Level</th>
                            <th>Sector</th>
                            <th>Type of Employment</th>
                            <th>Year Hired</th>
                            <th>Data Confirmation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['privacy_consent'] ? 'Yes' : 'No'; ?></td>
                                <td><?php echo $row['last_name']; ?></td>
                                <td><?php echo $row['first_name']; ?></td>
                                <td><?php echo $row['middle_name']; ?></td>
                                <td><?php echo $row['present_location']; ?></td>
                                <td><?php echo $row['present_address']; ?></td>
                                <td><?php echo $row['contact_number']; ?></td>
                                <td><?php echo $row['strand']; ?></td>
                                <td><?php echo $row['years_of_enrollment']; ?></td>
                                <td><?php echo $row['involvement']; ?></td>
                                <td><?php echo $row['academic_awards']; ?></td>
                                <td><?php echo $row['current_status']; ?></td>
                                <td><?php echo $row['university_employer']; ?></td>
                                <td><?php echo $row['position_year_level']; ?></td>
                                <td><?php echo $row['sector']; ?></td>
                                <td><?php echo $row['type_of_employment']; ?></td>
                                <td><?php echo $row['year_hired']; ?></td>
                                <td><?php echo $row['confirm_data'] ? 'Yes' : 'No'; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center">No records found.</p>
        <?php endif; ?>
    </div>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
