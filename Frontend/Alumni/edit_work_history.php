<?php
session_start();
include('../../Backend/db_connect.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'alumni') {
    header('Location: LandingPage.php');  
    exit();
}

$alumni_email = $_SESSION['user']['email'];

if (isset($_GET['id'])) {
    $work_history_id = $_GET['id'];

    $sql = "SELECT * FROM work_history WHERE id = ? AND alumni_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $work_history_id, $alumni_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $company_name = htmlspecialchars($row['company_name']);
        $position = htmlspecialchars($row['position']);
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
        $job_description = htmlspecialchars($row['job_description']);
    } else {
        echo "Work history not found.";
        exit();
    }
} else {
    echo "No work history ID provided.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_name = htmlspecialchars($_POST['company_name']);
    $position = htmlspecialchars($_POST['position']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $job_description = htmlspecialchars($_POST['job_description']);

    $sql = "UPDATE work_history SET company_name = ?, position = ?, start_date = ?, end_date = ?, job_description = ? 
            WHERE id = ? AND alumni_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssis", $company_name, $position, $start_date, $end_date, $job_description, $work_history_id, $alumni_email);

    if ($stmt->execute()) {
        header("Location: alumni_home.php?status=updated");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Work History</title>
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
            height: 100vh;
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
            margin-bottom: 70px;
        }

        .edit-work-history-form {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            font-family: 'Noticia Text', serif;
            background-color: #a00c30;
            border-color: #a00c30;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #da1a32;
            border-color: #da1a32;
        }

        @media only screen and (max-width: 600px) {

        .container {
            background-color: 0;
            height: 0;
            z-index: -2;
            box-shadow: none;
            padding-left: 0; 
            padding-right: 0; 
        }

        .logo {
            padding-top: 30px;
            width: 107px;
            margin-top: 20px;
            height: 112px;
            position: relative; 
            left: 50%;
            transform: translateX(-50%); 
            z-index: 1;
        }

        .edit-work-history-form {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 0;
            box-shadow: none;
        }

        .logoimg{
            margin-top:30px
        }

        .submitBtn{
                width: 100%;
            }


        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img alt="jee" src="../../images/banner.png" class="logoimg">
        </div>
        <div class="edit-work-history-form">
            <h1>Edit Work History</h1>
            <form action="edit_work_history.php?id=<?php echo $work_history_id; ?>" method="POST">
                <div class="mb-3">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo $company_name; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="position" class="form-label">Position</label>
                    <input type="text" class="form-control" id="position" name="position" value="<?php echo $position; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $start_date; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date (Optional)</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $end_date; ?>">
                </div>
                <div class="mb-3">
                    <label for="job_description" class="form-label">Job Description</label>
                    <textarea class="form-control" id="job_description" name="job_description" rows="3" required><?php echo $job_description; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary submitBtn">Update Work History</button>
            </form>
        </div>
    </div>
</body>
</html>
