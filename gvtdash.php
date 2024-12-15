<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agribridge";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Officers Data
$sql = "SELECT 
            id,
            position_title,
            department,
            responsibilities,
            availability
        FROM users
        WHERE user_type = 'officer'";

$result = $conn->query($sql);
$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Set the Content-Type to JSON
header('Content-Type: application/json');

// Return Data as JSON
echo json_encode($data);

// Close Connection
$conn->close();
?>
