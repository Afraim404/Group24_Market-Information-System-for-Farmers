<?php
// Database credentials
$host = 'localhost';   // Host name
$username = 'root';    // Database username (change if not root)
$password = '';        // Database password (leave empty for default)
$dbname = 'agribridge';     // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!";
}
?>