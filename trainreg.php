<?php
// Database connection details
$servername = "localhost"; // Change this to your database server
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "agribridge"; // The database you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $farmer_name = $_POST['farmer-name'];
    $farmer_id = $_POST['farmer-id'];
    $farm_location = $_POST['farm-location'];
    $phone = $_POST['phone'];
    $training_type = $_POST['training-type'];
    $comments = $_POST['comments'];

    // Prepare and bind SQL statement to insert the form data into the database
    $stmt = $conn->prepare("INSERT INTO pretrain (farmer_name, farmer_id, farm_location, phone, training_type, comments) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $farmer_name, $farmer_id, $farm_location, $phone, $training_type, $comments);

    // Execute the query
    if ($stmt->execute()) {
        echo "<p>Registration successful!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
