<?php
// Database Connection
$servername = "localhost"; // Replace with your server name
$username = "root";        // Replace with your database username
$password = "";            // Replace with your database password
$dbname = "agribridge";    // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Officer Data
$sql = "SELECT Officer_ID, PositionTitle, Department, Responsibilities, OfficeAvailability FROM government_officers";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // Fetch all rows
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Output data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close Connection
$conn->close();
?>
