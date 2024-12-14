<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agribridge";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

// Initialize the response data
$response = [
    "total_users" => 0,
    "total_orders" => 0,
    "total_revenue" => 0,
    "user_types" => [],
    "users" => [],
];

// Query to fetch total users, total orders, and total revenue
$sql = "
    SELECT 
        (SELECT COUNT(*) FROM users) AS total_users,
        (SELECT COUNT(*) FROM orders) AS total_orders,
        (SELECT IFNULL(SUM(total_price), 0) FROM orders) AS total_revenue
";

if ($result = $conn->query($sql)) {
    $row = $result->fetch_assoc();
    $response["total_users"] = $row["total_users"];
    $response["total_orders"] = $row["total_orders"];
    $response["total_revenue"] = $row["total_revenue"];
    $result->free();
} else {
    http_response_code(500);
    die(json_encode(["error" => "Failed to fetch summary data: " . $conn->error]));
}

// Query to get counts by user type
$sql_user_types = "SELECT user_type, COUNT(*) AS count FROM users GROUP BY user_type";
if ($result = $conn->query($sql_user_types)) {
    while ($row = $result->fetch_assoc()) {
        $response["user_types"][] = $row;
    }
    $result->free();
} else {
    http_response_code(500);
    die(json_encode(["error" => "Failed to fetch user types: " . $conn->error]));
}

// Query to fetch all users
$sql_users = "SELECT id, username, email, user_type FROM users";
if ($result = $conn->query($sql_users)) {
    while ($row = $result->fetch_assoc()) {
        $response["users"][] = $row;
    }
    $result->free();
} else {
    http_response_code(500);
    die(json_encode(["error" => "Failed to fetch users: " . $conn->error]));
}

// Close the database connection
$conn->close();

// Return the response as JSON
header("Content-Type: application/json");
echo json_encode($response, JSON_PRETTY_PRINT);
?> 