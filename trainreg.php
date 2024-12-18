<?php
// Database connection settings
$servername = "localhost";
$username = "root";        // Change to your database username
$password = "";            // Change to your database password
$dbname = "agribridge";    // Change to your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $farmer_name = $_POST['farmer-name'];
    $farmer_id = $_POST['farmer-id'];
    $farm_location = $_POST['farm-location'];
    $phone = $_POST['phone'];
    $training_type = $_POST['training-type'];
    $comments = $_POST['comments'];

    // Find the user ID by matching the farmer ID with the users table
    $sql_user = "SELECT id FROM users WHERE id = '$farmer_id' AND phone = '$phone' LIMIT 1";
    $result_user = $conn->query($sql_user);

    if ($result_user->num_rows > 0) {
        // Get the user ID
        $row = $result_user->fetch_assoc();
        $user_id = $row['id'];

        // Prepare the SQL query to insert the training registration
        $sql = "INSERT INTO training_registrations (user_id, farm_location, training_type, comments) 
                VALUES ('$user_id', '$farm_location', '$training_type', '$comments')";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "Training registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Farmer not found. Please check the Farmer ID and Phone Number.";
    }
}

// Close the connection
$conn->close();
?>
