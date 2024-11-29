<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agribridge";

$conn = new mysqli($servername, $username, $password, $dbname);

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session
session_start();

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $password = $conn->real_escape_string($_POST['password']);

    // Debug input values
    echo "User ID: $user_id<br>";
    echo "Password: $password<br>";

    // Query user
    $sql = "SELECT * FROM users WHERE user_id='$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo "User found: " . $user['full_name'] . "<br>";

        // Check password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];

            echo "Login successful! Redirecting...";
            header("Location: adminpanel.html");
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User ID does not exist!";
    }
}

$conn->close();
?>
