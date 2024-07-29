<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $apiKey = $_POST['apiKey'];
    $sender = $_POST['sender'];
    $number = $_POST['number'];
    $message = isset($_POST['message']) ? $_POST['message'] : '';
    $mediaType = isset($_POST['mediaType']) ? $_POST['mediaType'] : '';
    $caption = isset($_POST['caption']) ? $_POST['caption'] : '';

    // Determine message type
    if (!empty($mediaType) && isset($_FILES['mediaFile']) && $_FILES['mediaFile']['error'] === UPLOAD_ERR_OK) {
        // Handle media message
        $uploadDir = 'uploads/'; // Directory where uploads will be stored
        $uploadedFile = $_FILES['mediaFile']['tmp_name'];
        $fileExtension = pathinfo($_FILES['mediaFile']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $fileExtension; // Unique filename
        $targetPath = $uploadDir . $fileName;

        // Move uploaded file to destination
        if (move_uploaded_file($uploadedFile, $targetPath)) {
            // File upload successful, proceed with sending message and capturing URL
            $mediaUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $targetPath; // Replace with actual domain

            // Construct the API call or further processing logic
            $apiUrl = "https://wa.smartsender.cloud/send-media";
            $params = [
                'api_key' => $apiKey,
                'sender' => $sender,
                'number' => $number,
                'media_type' => $mediaType,
                'caption' => $caption,
                'url' => $mediaUrl,
            ];

            // Send request using cURL
            $response = sendCurlRequest($apiUrl, $params);

            if ($response === false) {
                echo "Error: Failed to send media message.";
            } else {
                echo "Media message sent successfully.";

                // Delete uploaded file after successful message sending
                deleteUploadedFile($targetPath);
            }
        } else {
            echo "Error: Failed to move uploaded file.";
        }
    } elseif (!empty($message)) {
        // Handle text message
        $apiUrl = "https://wa.smartsender.cloud/send-message";
        $params = [
            'api_key' => $apiKey,
            'sender' => $sender,
            'number' => $number,
            'message' => $message,
        ];

        // Send request using cURL
        $response = sendCurlRequest($apiUrl, $params);

        if ($response === false) {
            echo "Error: Failed to send text message.";
        } else {
            echo "Text message sent successfully.";
        }
    } else {
        echo "Error: Invalid request.";
    }
}

function sendCurlRequest($url, $params) {
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $params,
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

function deleteUploadedFile($filePath) {
    // Ensure the file path is within the upload directory for security reasons
    $uploadDir = 'uploads/';
    $fullPath = $uploadDir . basename($filePath);

    // Check if the file exists before attempting to delete it
    if (file_exists($fullPath)) {
        if (unlink($fullPath)) {
            echo "File deleted successfully.";
        } else {
            echo "Error: Failed to delete file.";
        }
    } else {
        echo "Error: File not found.";
    }
}
?>
