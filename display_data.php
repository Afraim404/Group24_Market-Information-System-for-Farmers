
<?php
include 'db-connection.php';  // Ensure this file is correctly included

// Fetch data from PriceHistory and Crops
$sql = "SELECT crops.CropName, pricehistory.Year, pricehistory.Season, pricehistory.Price
        FROM pricehistory
        JOIN crops ON pricehistory.CropID = crops.CropID
        ORDER BY pricehistory.Year, pricehistory.Season";

$result = $conn->query($sql);

// Create arrays to hold the data for the chart
$years = [];
$prices = [];
$crops = [];

if ($result->num_rows > 0) {
    // Collect the data into arrays
    while ($row = $result->fetch_assoc()) {
        $years[] = $row["Year"];
        $prices[] = $row["Price"];
        $crops[] = $row["CropName"];
    }
} else {
    echo "No data found.";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historical Price Trends</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        canvas {
            margin: auto;
        }
    </style>

</head>
<body>

<h1>Historical Price Trends</h1>

<canvas id="priceChart" width="400" height="200"></canvas>

<script>




// JavaScript to render Chart.js graph

// Data from PHP
var years = <?php echo json_encode($years); ?>;
var prices = <?php echo json_encode($prices); ?>;
var crops = <?php echo json_encode($crops); ?>;

// Prepare chart data
var chartData = {
    labels: years,  // X-axis will show years
    datasets: [{
        label: 'Price Trend',
        data: prices,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',  // Blue
        borderColor: 'rgba(54, 162, 235, 1)',  // Blue border
        borderWidth: 1
    }]
};

// Create the chart
var ctx = document.getElementById('priceChart').getContext('2d');
var priceChart = new Chart(ctx, {
    type: 'line',  // Line chart
    data: chartData,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

</body>
</html>
