<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "agribridge";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!<br>"; // Check if connection is successful
}

// SQL query to fetch government office data
$sql = "SELECT OfficeID, Location, ContactNumber, ServiceInformation FROM govt_offices";

// Check if the query executes properly
$result = $conn->query($sql);
if (!$result) {
    die("Query failed: " . $conn->error);
} else {
    echo "Query executed successfully!<br>"; // Log if query was successful
}

// Initialize an array to store office data
$offices = array();

// Check if rows were found
echo "Number of rows fetched: " . $result->num_rows . "<br>";

if ($result->num_rows > 0) {
    // Fetch each row of data and add to the array
    while($row = $result->fetch_assoc()) {
        $offices[] = $row;
    }
} else {
    // If no rows are found, return an empty array
    echo "No offices found.<br>";
    $offices = [];
}

// Output the office data as JSON
header('Content-Type: application/json');
echo json_encode($offices);

// Close the connection
$conn->close();
?>
