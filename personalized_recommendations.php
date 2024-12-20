<?php
// Database connection setup
$host = "localhost";
$dbname = "agribridge";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seasonal Recommendations | agriBridge</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="gvtdash.css">
    <style>
        /* Basic Styles */
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9; }
        h2, h3 { color: #2c7f47; text-align: center; }
        .container { margin: 2rem auto; width: 90%; max-width: 1200px; }
        table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 0.75rem; text-align: center; }
        th { background-color: #2c7f47; color: #fff; }

        /* Cards Section */
        .card-container { display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center; }
        .season-card { background-color: #2c7f47; color: white; border-radius: 8px; padding: 1.5rem; width: 300px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15); }
        .season-card ul { list-style: none; padding: 0; }
        .season-card li { margin-bottom: 0.5rem; }

        /* Form Section */
        form { background-color: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin-top: 2rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; font-weight: bold; margin-bottom: 0.5rem; }
        input, textarea { width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #2c7f47; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #256d3e; }

        /* Navigation Bar */
        .nav-left {
            display: flex;
            align-items: center;
        }
        .nav-items {
            list-style-type: none;
            display: flex;
            margin-left: auto;
        }
        .nav-items li {
            margin: 0 1rem;
        }
        .nav-items a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
        }
        .nav-items a:hover {
            color: #2c7f47;
        }
        .nav-right i {
            font-size: 1.5rem;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 1rem;
            background-color: #2c7f47;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <nav>
            <div class="nav-left">
                <img src="LogoNoBG.png" alt="agriBridge" class="nav-logo">
                <ul class="nav-items">
                    <li><a href="homepage.html">Home</a></li>
                    <li><a href="login.html">Sign Out</a></li> <!-- Sign out link -->
                </ul>
            </div>
            <div class="nav-right">
                <i class="fa-solid fa-database databaseicon"></i>
            </div>
        </nav>
    </header>

    <!-- Problem Submission Form -->
    <h2>Submit Your Problem</h2>
    <form method="POST" action="submit_problem.php">
        <div class="form-group">
            <label for="cropType">Crop Type:</label>
            <input type="text" id="cropType" name="cropType" required>
        </div>
        <div class="form-group">
            <label for="problemDescription">Describe Your Problem:</label>
            <textarea id="problemDescription" name="problemDescription" rows="5" required></textarea>
        </div>
        <button type="submit">Submit Problem</button>
    </form>

    <!-- Recommendations Table -->
    <h2>All Recommendations</h2>
    <table>
        <thead>
            <tr>
                <th>Crop</th>
                <th>Season</th>
                <th>Recommendation</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch all recommendations
            $recommendationsQuery = "SELECT crop_name, season, recommendation FROM seasonal_recommendations";
            foreach ($conn->query($recommendationsQuery) as $row) {
                echo "<tr>
                        <td>{$row['crop_name']}</td>
                        <td>{$row['season']}</td>
                        <td>{$row['recommendation']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 agriBridge. All rights reserved.</p>
    </footer>

</body>
</html>