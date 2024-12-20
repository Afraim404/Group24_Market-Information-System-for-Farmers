<?php
// Start the session
session_start();

// Include the database connection file
include('db-connection.php');

// Initialize error message
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string(trim($_POST['username']));
    $user_type = $conn->real_escape_string(trim($_POST['user_type']));

    // Check if the username and user type are valid
    $sql = "SELECT * FROM users WHERE username = ? AND user_type = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $user_type);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // User exists
        $user = $result->fetch_assoc();

        // Store user information in the session
        $_SESSION['User_ID'] = $user['id'];
        $_SESSION['Username'] = $user['username'];
        $_SESSION['UserType'] = $user['user_type'];

        // Redirect to the dashboard based on user type
        switch ($user['user_type']) {
            case 'Farmer':
                header('Location: farmerdashboard.html');
                break;
            case 'Officer':
                header('Location: gvtdash.html');
                break;
            case 'Customer':
                header('Location: customer.php');
                break;
            case 'Admin':
                header('Location: adminpanel.html');
                break;
            default:
                $error_message = "Invalid user type.";
        }
        exit();
    } else {
        $error_message = "Invalid username or user type.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <form action="" method="POST">
            <h1>Login</h1>
            <?php if (!empty($error_message)) { ?>
                <div class="error-message"> <?php echo $error_message; ?> </div>
            <?php } ?>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <select name="user_type" required>
                    <option value="" disabled selected>Select User Type</option>
                    <option value="Farmer">Farmer</option>
                    <option value="Officer">Officer</option>
                    <option value="Customer">Customer</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="register-link">
                <p>Don't have an account? <a href="register.html">Register</a></p>
            </div>
        </form>
    </div>
</body>

</html>
