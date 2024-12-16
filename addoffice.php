<?php
// addoffice.php

header("Content-Type: application/json");

// Database credentials
$host = "localhost";
$user = "root";
$password = "";
$database = "agribridge";

// Connect to MySQL
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

// Retrieve form data
$officeID = $_POST['office-id'];
$location = $_POST['location'];
$contactNumber = $_POST['contact-number'];
$serviceInfo = $_POST['service-info'];

// Insert data into database
$sql = "INSERT INTO govt_offices (OfficeID, Location, ContactNumber, ServiceInformation)
        VALUES ('$officeID', '$location', '$contactNumber', '$serviceInfo')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => "Office added successfully"]);
} else {
    echo json_encode(["error" => "Error: " . $conn->error]);
}

$conn->close();
?>
