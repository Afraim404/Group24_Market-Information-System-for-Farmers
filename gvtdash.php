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

// SQL Query to Fetch Data from users Table (where user_type = 'officer')
$sql = "SELECT 
            id,
            position_title,
            department,
            responsibilities,
            availability
        FROM users
        WHERE user_type = 'officer'";  // Assuming there is a user_type column with 'officer' as a value

// Execute the Query
$result = $conn->query($sql);

// Initialize an Array to Hold Data
$data = array();

if ($result && $result->num_rows > 0) {
    // Fetch All Rows
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    // Return an Empty Array if No Data Found
    $data = [];
}

// Set the Content-Type to JSON
header('Content-Type: application/json');

// Return Data as JSON
echo json_encode($data);

// Close the Database Connection
$conn->close();
?>