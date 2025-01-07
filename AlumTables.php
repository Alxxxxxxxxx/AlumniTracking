<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Table - School Alumni</title>
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2 class="mb-4">Alumni Data</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
        </tr>
        </thead>
        <tbody>
        <?php
    
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'school_alumni';

        $conn = new mysqli($host, $username, $password, $database);

       
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        
        $sql = "SELECT * FROM tables";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['created_at']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='text-center'>No records found</td></tr>";
        }

        $conn->close();
        ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
