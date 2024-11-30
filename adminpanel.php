<?php
// admin.php

// Database connection
$servername = "localhost";  // Your database server
$username = "root";         // Your database username
$password = "";             // Your database password
$dbname = "agribridge";     // Your database name

// Database connection
$conn = new mysqli('localhost', 'root', '', 'agribridge');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users from the database
$sql = "SELECT User_ID, Username, Email, UserType FROM users"; // Replace `users` with your table name
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Output JSON for AJAX requests
header('Content-Type: application/json');
echo json_encode($users);

// Close connection
$conn->close();
?>
