<?php
// govtoffice.php

header("Content-Type: application/json");

// Database credentials
$host = "localhost";     // Your database host
$user = "root";          // Your database username
$password = "";          // Your database password
$database = "agribridge"; // Your database name

// Connect to MySQL
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

// Fetch all government offices
$sql = "SELECT OfficeID, Location, ContactNumber, ServiceInformation FROM govt_offices";
$result = $conn->query($sql);

$offices = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $offices[] = $row;
    }
}

// Send JSON response
echo json_encode($offices);

// Close connection
$conn->close();
?>
