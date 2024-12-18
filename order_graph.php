<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['User_ID']) || $_SESSION['UserType'] !== 'Customer') {
    header("Location: login.php");
    exit();
}

// Database connection
$mysqli = new mysqli('localhost', 'root', '', 'agribridge');

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get the user ID from the session
$user_id = $_SESSION['User_ID'];

// Prepare query to get orders by day of the month
$query = "SELECT 
            DAY(created_at) as day_of_month, 
            COUNT(*) as order_count 
          FROM orders 
          WHERE user_id = ? 
            AND MONTH(created_at) = MONTH(CURRENT_DATE()) 
            AND YEAR(created_at) = YEAR(CURRENT_DATE())
          GROUP BY DAY(created_at)
          ORDER BY DAY(created_at)";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Prepare data for Chart.js
$days = [];
$orderCounts = [];

// Create an array for all days of the current month (initialized to 0)
$currentMonth = date('t'); // Number of days in current month
for ($i = 1; $i <= $currentMonth; $i++) {
    $days[] = $i;
    $orderCounts[] = 0;
}

// Fill in actual order counts
while ($row = $result->fetch_assoc()) {
    // Find the index of the day and update the order count
    $dayIndex = array_search($row['day_of_month'], $days);
    if ($dayIndex !== false) {
        $orderCounts[$dayIndex] = $row['order_count'];
    }
}

$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Order History</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="chart-container">
        <canvas id="monthlyOrderChart"></canvas>
    </div>

    <script>
        // Prepare data for Chart.js
        const days = <?php echo json_encode($days); ?>;
        const orderCounts = <?php echo json_encode($orderCounts); ?>;

        // Create the line chart
        const ctx = document.getElementById('monthlyOrderChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: days,
                datasets: [{
                    label: 'Number of Orders',
                    data: orderCounts,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Your Monthly Order History'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Day of Month'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Number of Orders'
                        },
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>