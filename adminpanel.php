<?php
// admin.php

// Database connection
$servername = "localhost";  // Your database server
$username = "root";         // Your database username
$password = "";             // Your database password
$dbname = "agribridge";     // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users from the database
$sql = "SELECT User_ID, Username, Email, UserType FROM users";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    // Fetch all users
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    echo "No users found.";
}

// Close the connection
$conn->close();
?>
