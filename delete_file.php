<?php
// delete_file.php - Server-side script to delete uploaded file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filename'])) {
    $uploadDir = 'uploads/'; // Directory where files are uploaded
    $filename = $_POST['filename'];
    $filePath = $uploadDir . $filename;

    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            echo 'File deleted successfully';
        } else {
            echo 'Failed to delete file';
        }
    } else {
        echo 'File does not exist';
    }
}
?>
