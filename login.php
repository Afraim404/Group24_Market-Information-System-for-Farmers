<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agribridge";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $user_type = mysqli_real_escape_string($conn, trim($_POST['user_type']));

    // Debugging input (Optional)
    // echo "Debug: Entered Username = $username<br>";
    // echo "Debug: Entered User Type = $user_type<br>";

    // Query to check if the username and user type exist in the database
    $sql = "SELECT * FROM users WHERE username = '$username' AND user_type = '$user_type'";
    
    // Debugging query (Optional)
    // echo "Debug: SQL Query = $sql<br>";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Debugging if the user is found (Optional)
        // echo "Debug: User found!<br>";

        // Set session variables
        $_SESSION['user_id'] = $row['id']; // Use the correct column name for ID
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_type'] = $row['user_type'];

        // Redirect based on user type
        if ($row['user_type'] === 'Admin') {
            header("Location: adminpanel.html");
        } elseif ($row['user_type'] === 'Farmer') {
            header("Location: farmerdashboard.html");
        } elseif ($row['user_type'] === 'Officer') {
            header("Location: gvtdash.html");
        } elseif ($row['user_type'] === 'Customer') {
            header("Location: customer.html");
        } else {
            // Optional: Handle invalid user type
            echo "Invalid user type.<br>";
        }
        exit;
    } else {
        echo "Invalid Username or User Type<br>";
    }
}

$conn->close();
?>
