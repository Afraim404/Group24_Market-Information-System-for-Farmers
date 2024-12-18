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
    $username = trim($_POST['username']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $gender = trim($_POST['gender']);
    $user_type = trim($_POST['user_type']);

    // Officer-specific data (if applicable)
    $position_title = isset($_POST['position_title']) ? trim($_POST['position_title']) : null;
    $department = isset($_POST['department']) ? trim($_POST['department']) : null;
    $responsibilities = isset($_POST['responsibilities']) ? trim($_POST['responsibilities']) : null;
    $availability = isset($_POST['availability']) ? trim($_POST['availability']) : null;

    // Validate required fields
    if (empty($username) || empty($phone) || empty($email) || empty($address) || empty($gender) || empty($user_type)) {
        echo "All fields are required. Please fill in all the details.";
        exit;
    }

    // Check if the username already exists
    $stmt_check = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "Username already taken. Please choose another one.";
        $stmt_check->close();
        exit;
    }
    $stmt_check->close();

    // Insert the new user into the database
    if ($user_type === 'Officer') {
        $stmt = $conn->prepare("INSERT INTO users (username, phone, email, address, gender, user_type, position_title, department, responsibilities, availability) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $username, $phone, $email, $address, $gender, $user_type, $position_title, $department, $responsibilities, $availability);
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, phone, email, address, gender, user_type) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $username, $phone, $email, $address, $gender, $user_type);
    }

    if ($stmt->execute()) {
        echo "Registration successful! You can <a href='login.html'>login</a> now.";

        // Optionally, auto-login the user after registration
        $_SESSION['username'] = $username;
        $_SESSION['user_type'] = $user_type;
        header("Location: login.html"); // Redirect to login page
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
