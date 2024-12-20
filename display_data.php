<?php
include 'db-connection.php'; // Ensure this file connects to your database

// Fetch data for dropdown filters
$cropQuery = "SELECT DISTINCT CropName FROM crops_catagory";
$yearQuery = "SELECT DISTINCT Year FROM pricehistory ORDER BY Year";

$crops = $conn->query($cropQuery);
$years = $conn->query($yearQuery);

// Fetch data for the graph and table based on filters
$selectedCrop = $_GET['crop'] ?? '';
$selectedYear = $_GET['year'] ?? '';
$selectedSeason = $_GET['season'] ?? '';

$conditions = [];
if ($selectedCrop) $conditions[] = "crops_catagory.CropName = '$selectedCrop'";
if ($selectedYear) $conditions[] = "pricehistory.Year = '$selectedYear'";
if ($selectedSeason) $conditions[] = "pricehistory.Season = '$selectedSeason'";

$whereClause = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';

$sql = "SELECT crops_catagory.CropName, pricehistory.Year, pricehistory.Season, pricehistory.Price
        FROM pricehistory
        JOIN crops_catagory ON pricehistory.CropID = crops_catagory.CropID
        $whereClause
        ORDER BY pricehistory.Year, pricehistory.Season";

$result = $conn->query($sql);

// Prepare data for the chart and table
$data = [];
$chartYears = [];
$chartPrices = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
        $chartYears[] = $row["Year"] . " (" . $row["Season"] . ")";
        $chartPrices[] = $row["Price"];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historical Price Trends and Market Analysis</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; text-align: center; }
        canvas { margin: 20px auto; }
        table { margin: 20px auto; border-collapse: collapse; width: 80%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #4CAF50; color: white; }
        select { margin: 10px; padding: 5px; }
    </style>
</head>
<body>

<h1>Historical Price Trends and Market Analysis</h1>

<!-- Filter Form -->
<form method="GET" action="">
    <label for="crop">Crop:</label>
    <select name="crop" id="crop">
        <option value="">All</option>
        <?php while ($row = $crops->fetch_assoc()): ?>
            <option value="<?php echo $row['CropName']; ?>" <?php if ($selectedCrop == $row['CropName']) echo 'selected'; ?>>
                <?php echo $row['CropName']; ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label for="year">Year:</label>
    <select name="year" id="year">
        <option value="">All</option>
        <?php while ($row = $years->fetch_assoc()): ?>
            <option value="<?php echo $row['Year']; ?>" <?php if ($selectedYear == $row['Year']) echo 'selected'; ?>>
                <?php echo $row['Year']; ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label for="season">Season:</label>
    <select name="season" id="season">
        <option value="">All</option>
        <option value="Summer" <?php if ($selectedSeason == 'Summer') echo 'selected'; ?>>Summer</option>
        <option value="Winter" <?php if ($selectedSeason == 'Winter') echo 'selected'; ?>>Winter</option>
    </select>

    <button type="submit">Filter</button>
</form>

<!-- Chart -->
<canvas id="priceChart" width="600" height="300"></canvas>

<!-- Data Table -->
<?php if (!empty($data)): ?>
    <h2>Price Data Table</h2>
    <table>
        <tr>
            <th>Crop Name</th>
            <th>Year</th>
            <th>Season</th>
            <th>Price</th>
        </tr>
        <?php foreach ($data as $row): ?>
            <tr>
                <td><?php echo $row['CropName']; ?></td>
                <td><?php echo $row['Year']; ?></td>
                <td><?php echo $row['Season']; ?></td>
                <td><?php echo $row['Price']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No data found for the selected filters.</p>
<?php endif; ?>

<script>
// Data for the chart
var chartLabels = <?php echo json_encode($chartYears); ?>;
var chartData = <?php echo json_encode($chartPrices); ?>;

var ctx = document.getElementById('priceChart').getContext('2d');
var priceChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: chartLabels,
        datasets: [{
            label: 'Price Trend',
            data: chartData,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

</body>
</html>
