<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agribridge";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $user_type = mysqli_real_escape_string($conn, trim($_POST['user_type']));

    // Debugging input
    echo "Debug: Entered Username = $username<br>";
    echo "Debug: Entered User Type = $user_type<br>";

    // Query to check username and user type
    $sql = "SELECT * FROM users WHERE Username = '$username' AND UserType = '$user_type'";
    echo "Debug: SQL Query = $sql<br>";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "Debug: User found!<br>";

        $_SESSION['User_ID'] = $row['User_ID'];
        $_SESSION['Username'] = $row['Username'];
        $_SESSION['UserType'] = $row['UserType'];

        // Redirect based on user type
        if ($row['UserType'] === 'Admin') {
            header("Location: adminpanel.html");
        } elseif ($row['UserType'] === 'Farmer') {
            header("Location: farmerdashboard.html");
        } elseif ($row['UserType'] === 'Officer') {
            header("Location: gvtdash.html");
        } else {
            header("Location: customer.html");
        }
        exit;
    } else {
        echo "Invalid Username or User Type<br>";
    }
}

$conn->close();
?>
