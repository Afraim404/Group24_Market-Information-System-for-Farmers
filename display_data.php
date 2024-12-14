<?php
include 'db_connection.php';

// Fetch data from PriceHistory and Crops
$sql = "SELECT Crops.CropName, PriceHistory.Year, PriceHistory.Season, PriceHistory.Price
        FROM PriceHistory
        JOIN Crops ON PriceHistory.CropID = Crops.CropID
        ORDER BY Year, Season";

$result = $conn->query($sql);

// Display the data
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Crop Name</th>
                <th>Year</th>
                <th>Season</th>
                <th>Price</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["CropName"] . "</td>
                <td>" . $row["Year"] . "</td>
                <td>" . $row["Season"] . "</td>
                <td>" . $row["Price"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No data found.";
}

$conn->close();
?>