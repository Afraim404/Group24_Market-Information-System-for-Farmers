<?php
// Connect to the database
$host = "localhost";
$dbname = "agribridge";
$username = "root";
$password = "";
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch recommendations from the database
$query = "SELECT * FROM seasonal_recommendations";
$stmt = $conn->prepare($query);
$stmt->execute();

// Display the recommendations in a table
echo '<section id="recommendation-table" class="feature-section">
        <h2>Seasonal Recommendations</h2>
        <table id="recommendations-table">
            <thead>
                <tr>
                    <th>Crop</th>
                    <th>Season</th>
                    <th>Recommendation</th>
                </tr>
            </thead>
            <tbody>';

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>
            <td>{$row['crop_name']}</td>
            <td>{$row['season']}</td>
            <td>{$row['recommendation']}</td>
          </tr>";
}

echo '  </tbody>
      </table>
    </section>';
?>
