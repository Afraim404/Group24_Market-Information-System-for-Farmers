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
    // Get input data and sanitize it
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $address = mysqli_real_escape_string($conn, trim($_POST['address']));
    $gender = mysqli_real_escape_string($conn, trim($_POST['gender']));
    $user_type = mysqli_real_escape_string($conn, trim($_POST['user_type']));

    // Debugging input (Optional)
    // echo "Debug: Entered Username = $username<br>";
    // echo "Debug: Entered Phone = $phone<br>";
    // echo "Debug: Entered Email = $email<br>";
    // echo "Debug: Entered Address = $address<br>";
    // echo "Debug: Entered Gender = $gender<br>";
    // echo "Debug: Entered User Type = $user_type<br>";

    // Check if the username already exists
    $sql_check = "SELECT * FROM users WHERE username = '$username'";
    $result_check = $conn->query($sql_check);

    if ($result_check && $result_check->num_rows > 0) {
        echo "Username already taken. Please choose another one.";
    } else {
        // Insert the new user into the database
        $sql = "INSERT INTO users (username, phone, email, address, gender, user_type) 
                VALUES ('$username', '$phone', '$email', '$address', '$gender', '$user_type')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful! You can <a href='login.html'>login</a> now.";
            
            // Optionally, you can auto-login the user after registration
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = $user_type;
            header("Location: login.html"); // Redirect to login page
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
