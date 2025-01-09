<?php
include '../../Backend/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['photo_id'])) {
    $photoId = $_POST['photo_id'];

 
    $stmt = $conn->prepare("SELECT photo_name FROM slideshow_photos WHERE id = ?");
    $stmt->bind_param("i", $photoId);
    $stmt->execute();
    $stmt->bind_result($photoName);
    $stmt->fetch();
    $stmt->close();

    if ($photoName) {
        $filePath = '../../images/slideshow/' . $photoName;

       
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        
        $stmt = $conn->prepare("DELETE FROM slideshow_photos WHERE id = ?");
        $stmt->bind_param("i", $photoId);
        $stmt->execute();
        $stmt->close();

        echo "Photo deleted successfully.";
    } else {
        echo "Error: Photo not found.";
    }
    header('Location: admin_dashboard.php'); // Redirect back
    exit();
}
?>
