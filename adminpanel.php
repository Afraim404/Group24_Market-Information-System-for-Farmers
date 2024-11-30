<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agribridge"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to count total users
$sql = "SELECT COUNT(*) AS total_users FROM users";
$result = $conn->query($sql);

// Fetch the result for total users
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_users = $row['total_users'];
} else {
    $total_users = 0;
}

// SQL query to get user types
$sql_user_types = "SELECT UserType, COUNT(*) AS count FROM users GROUP BY UserType";
$user_types_result = $conn->query($sql_user_types);

// Fetch the user type counts
$user_types = [];
if ($user_types_result->num_rows > 0) {
    while ($row = $user_types_result->fetch_assoc()) {
        $user_types[] = $row;
    }
}

// SQL query to get all users (for the table)
$sql_users = "SELECT User_ID, Username, Email, UserType FROM users";
$users_result = $conn->query($sql_users);

// Fetch all users
$users = [];
if ($users_result->num_rows > 0) {
    while ($row = $users_result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Close the connection
$conn->close();

// Return the data as JSON
echo json_encode(["total_users" => $total_users, "users" => $users, "user_types" => $user_types]);
?>
