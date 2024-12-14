<?php
$servername = "localhost"; // XAMPP server
$username = "root";        // Default MySQL username
$password = "zerotonine(";            // Default MySQL password is empty
$dbname = "pricetrends";   // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully to the database.";
?>