<?php
// Include database configuration
require_once 'config.php';

// Initialize session (if not already started)
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['newPassword']);

    // Hash the password (optional, but highly recommended for security)
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Query to insert new user into database
    $query = "INSERT INTO users (email, password_hash) VALUES ('$email', '$password_hash')";

    if ($mysqli->query($query) === TRUE) {
        // Registration successful
        $_SESSION['email'] = $email; // Store email in session variable
        header("Location: wa.html"); // Redirect to dashboard or any other page
        exit();
    } else {
        // Registration failed
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }
}

// Close database connection
$mysqli->close();
?>
