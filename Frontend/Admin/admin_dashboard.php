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
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noticia+Text&display=swap" rel="stylesheet">
    <link rel="icon" href="../../images/logo.ico" type="image/logo">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
        }

        p {
            font-size: 1.2rem;
            color: #222222;
            font-family: 'Noticia Text', serif;
            margin-bottom: 40px;
        }

        .filters {
            margin-bottom: 10px;
        }

        .filters select, .filters input[type="text"] {
            margin: 3px;
        }

        .btn-primary{
            font-family: 'Noticia Text', serif;
            background-color: #a00c30;
            border-color: #a00c30;
            margin: 3px;
        }

        .btn-primary:hover{
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
            background-color:  #da1a32;
        }
    </style>
</head>
<body>
    <div class="container">
            <div class="logo">
                <img alt="jee" src="../../images/banner.png">
            </div>
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
                            <th>Actions</th>
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
                                <td>
                                    <a href="edit_alumni.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete_alumni.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        
</div>
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#slideshowModal">Manage Slideshow</button>
    </div>
<!-- Slideshow Modal -->
<div class="modal fade" id="slideshowModal" tabindex="-1" aria-labelledby="slideshowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="slideshowModalLabel">Manage Slideshow Photos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                    
                    $sql = "SELECT * FROM slideshow_photos";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0):
                        while ($row = $result->fetch_assoc()): ?>
                            <div class="col-md-4 text-center mb-4">
                                <img src="../../images/slideshow/<?= $row['photo_name']; ?>" alt="Slideshow Image" class="img-thumbnail" style="height: 150px; width: auto;">
                                <form action="delete_photo.php" method="POST" class="mt-2">
                                    <input type="hidden" name="photo_id" value="<?= $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        <?php endwhile;
                    else: ?>
                        <p class="text-center">No photos found in the slideshow.</p>
                    <?php endif; ?>
                </div>

                <hr>
                <form action="upload_photo.php" method="POST" enctype="multipart/form-data">
                    <label for="photo" class="form-label">Add New Photo:</label>
                    <input type="file" name="photo" id="photo" class="form-control" accept="image/*" required>
                    <button type="submit" class="btn btn-success mt-2">Upload</button>
                </form>
            </div>
        </div>
    </div>
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
