<?php
// Include database configuration
require_once 'config.php';

// Initialize session (if not already started)
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);

    // Query to check if user exists
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = $mysqli->query($query);

    if ($result->num_rows == 1) {
        // User found, verify password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password_hash'])) {
            // Password is correct, login successful
            $_SESSION['email'] = $email; // Store email in session variable
            $_SESSION['user_id'] = $user['id']; // Optionally store user ID or other data
            header("Location: wa.html"); // Redirect to dashboard or any other page
            exit();
        } else {
            // Incorrect password
            echo "Invalid email or password";
        }
    } else {
        // User not found
        echo "User not found";
    }
}

// Close database connection
$mysqli->close();
?>
