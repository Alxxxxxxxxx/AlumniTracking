<?php
session_start();

// Check if the session exists and the user is an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: LandingPage.php'); // Redirect if not logged in as admin
    exit();
}

// Include database connection
include '../../Backend/db_connect.php';

// Initialize filters
$filters = [
    'present_location' => isset($_GET['present_location']) ? $_GET['present_location'] : '',
    'strand' => isset($_GET['strand']) ? $_GET['strand'] : '',
    'sector' => isset($_GET['sector']) ? $_GET['sector'] : '',
    'type_of_employment' => isset($_GET['type_of_employment']) ? $_GET['type_of_employment'] : '',
    'search' => isset($_GET['search']) ? $_GET['search'] : ''
];

// Build the SQL query with filters
$sql = "SELECT * FROM alumni WHERE 1";

if (!empty($filters['present_location'])) {
    $sql .= " AND present_location = '" . $conn->real_escape_string($filters['present_location']) . "'";
}

if (!empty($filters['strand'])) {
    $sql .= " AND strand = '" . $conn->real_escape_string($filters['strand']) . "'";
}

if (!empty($filters['sector'])) {
    $sql .= " AND sector = '" . $conn->real_escape_string($filters['sector']) . "'";
}

if (!empty($filters['type_of_employment'])) {
    $sql .= " AND type_of_employment = '" . $conn->real_escape_string($filters['type_of_employment']) . "'";
}

if (!empty($filters['search'])) {
    $sql .= " AND (
        email LIKE '%" . $conn->real_escape_string($filters['search']) . "%' OR
        last_name LIKE '%" . $conn->real_escape_string($filters['search']) . "%' OR
        first_name LIKE '%" . $conn->real_escape_string($filters['search']) . "%' OR
        middle_name LIKE '%" . $conn->real_escape_string($filters['search']) . "%'
    )";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: hsl(51, 100.00%, 89.40%);
            color: rgb(26, 26, 26);
        }
        h1 {
            color: rgb(49, 49, 49);
            text-align: center;
        }
        .filters {
            margin-bottom: 20px;
        }
        .filters select, .filters input[type="text"] {
            margin-right: 10px;
        }
        .logout {
            display: block;
            text-align: center;
            color: #ffffff;
            background-color: #ff4c4c;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .logout:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <p class="text-center">Welcome, Admin!</p>

        <form class="filters" method="GET" action="">
            <select name="present_location" class="form-select" style="width: auto; display: inline-block;">
                <option value="">Present Location (All)</option>
                <option value="In the Philippines" <?= $filters['present_location'] == 'In the Philippines' ? 'selected' : '' ?>>In the Philippines</option>
            </select>
            <select name="strand" class="form-select" style="width: auto; display: inline-block;">
                <option value="">Strand (All)</option>
                <option value="Science, Technology, Engineering, and Mathematics" <?= $filters['strand'] == 'Science, Technology, Engineering, and Mathematics' ? 'selected' : '' ?>>Science, Technology, Engineering, and Mathematics</option>
                <option value="Humanities and Social Sciences" <?= $filters['strand'] == 'Humanities and Social Sciences' ? 'selected' : '' ?>>Humanities and Social Sciences</option>
                <option value="Accountancy, Businesses, and Management" <?= $filters['strand'] == 'Accountancy, Businesses, and Management' ? 'selected' : '' ?>>Accountancy, Businesses, and Management</option>
                <option value="Information and Communication Technology" <?= $filters['strand'] == 'Information and Communication Technology' ? 'selected' : '' ?>>Information and Communication Technology</option>
                <option value="Food and Beverages" <?= $filters['strand'] == 'Food and Beverages' ? 'selected' : '' ?>>Food and Beverages</option>
                <option value="Other" <?= $filters['strand'] == 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
            <select name="sector" class="form-select" style="width: auto; display: inline-block;">
                <option value="">Sector (All)</option>
                <option value="Private" <?= $filters['sector'] == 'Private' ? 'selected' : '' ?>>Private</option>
                <option value="Public" <?= $filters['sector'] == 'Public' ? 'selected' : '' ?>>Public</option>
                <option value="Government" <?= $filters['sector'] == 'Government' ? 'selected' : '' ?>>Government</option>
                <option value="NGO" <?= $filters['sector'] == 'NGO' ? 'selected' : '' ?>>NGO</option>
                <option value="Non-Profit" <?= $filters['sector'] == 'Non-Profit' ? 'selected' : '' ?>>Non-Profit</option>
            </select>
            <select name="type_of_employment" class="form-select" style="width: auto; display: inline-block;">
                <option value="">Type of Employment (All)</option>
                <option value="Full-time" <?= $filters['type_of_employment'] == 'Full-time' ? 'selected' : '' ?>>Full-time</option>
                <option value="Part-time" <?= $filters['type_of_employment'] == 'Part-time' ? 'selected' : '' ?>>Part-time</option>
            </select>
            <input type="text" name="search" class="form-control" placeholder="Search..." value="<?= $filters['search'] ?>" style="width: auto; display: inline-block;">
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= $row['email']; ?></td>
                                <td><?= $row['last_name']; ?></td>
                                <td><?= $row['first_name']; ?></td>
                                <td><?= $row['middle_name']; ?></td>
                                <td><?= $row['present_location']; ?></td>
                                <td><?= $row['present_address']; ?></td>
                                <td><?= $row['contact_number']; ?></td>
                                <td><?= $row['strand']; ?></td>
                                <td><?= $row['years_of_enrollment']; ?></td>
                                <td><?= $row['involvement']; ?></td>
                                <td><?= $row['academic_awards']; ?></td>
                                <td><?= $row['current_status']; ?></td>
                                <td><?= $row['university_employer']; ?></td>
                                <td><?= $row['position_year_level']; ?></td>
                                <td><?= $row['sector']; ?></td>
                                <td><?= $row['type_of_employment']; ?></td>
                                <td><?= $row['year_hired']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center">No records found.</p>
        <?php endif; ?>

        <a href="../../logout.php" class="logout">Logout</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
