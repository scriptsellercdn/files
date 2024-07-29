<?php
// Database configuration
define('DB_HOST', 'localhost'); // Database host (usually 'localhost')
define('DB_USERNAME', 'u622789038_ygfbnuyg56'); // Database username
define('DB_PASSWORD', 'h]N81lpX'); // Database password
define('DB_NAME', 'u622789038_ygfbnuyg56'); // Database name

// Connect to MySQL database
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
