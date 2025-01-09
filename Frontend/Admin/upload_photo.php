<?php
include '../../Backend/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $uploadDir = '../../images/slideshow/';
    $photoName = basename($_FILES['photo']['name']);
    $uploadFile = $uploadDir . $photoName;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); 
    }

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
        
        $stmt = $conn->prepare("INSERT INTO slideshow_photos (photo_name) VALUES (?)");
        $stmt->bind_param("s", $photoName);
        $stmt->execute();
        $stmt->close();

        echo "Photo uploaded successfully.";
    } else {
        echo "Error uploading photo.";
    }
    header('Location: admin_dashboard.php'); 
    exit();
}
?>
