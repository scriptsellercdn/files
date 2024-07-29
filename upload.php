<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            $response = array('fileName' => basename($_FILES['file']['name']));
            echo json_encode($response);
        } else {
            http_response_code(500);
            echo json_encode(array('error' => 'Failed to move uploaded file.'));
        }
    } else {
        http_response_code(400);
        echo json_encode(array('error' => 'No file uploaded or upload error.'));
    }
} else {
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed.'));
}
