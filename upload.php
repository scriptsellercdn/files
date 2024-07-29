<?php

// Check if a file was uploaded
if (isset($_FILES['mediaFile'])) {
    $file = $_FILES['mediaFile'];

    // File details
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    // File extension
    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

    // Allowed file extensions
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'pdf'];

    // Check if file extension is allowed
    if (in_array(strtolower($fileExt), $allowedExtensions)) {
        // Check for upload errors
        if ($fileError === UPLOAD_ERR_OK) {
            // Generate unique filename to prevent overwriting existing files
            $fileNameNew = uniqid('', true) . '.' . $fileExt;
            $fileDestination = 'uploads/' . $fileNameNew;

            // Move uploaded file to destination
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                // File uploaded successfully
                echo json_encode([
                    'success' => true,
                    'file_name' => $fileNameNew,
                    'file_path' => $fileDestination
                ]);
            } else {
                // Failed to move uploaded file
                echo json_encode([
                    'success' => false,
                    'error' => 'Failed to move uploaded file'
                ]);
            }
        } else {
            // Upload error
            echo json_encode([
                'success' => false,
                'error' => 'Upload error: ' . $fileError
            ]);
        }
    } else {
        // Invalid file extension
        echo json_encode([
            'success' => false,
            'error' => 'Invalid file extension. Allowed extensions: ' . implode(', ', $allowedExtensions)
        ]);
    }
} else {
    // No file uploaded or invalid request
    echo json_encode([
        'success' => false,
        'error' => 'No file uploaded or invalid request'
    ]);
}
