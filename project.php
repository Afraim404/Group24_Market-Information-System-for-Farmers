<?php
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "agribridge";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// Fetch crops data for the chart
$chartData = [];
$sql = "SELECT Crop_Name, Crop_Price FROM crop";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $chartData[] = $row;
    }
}







function insertCrop($conn, $cropName, $cropUnit, $cropPrice, $cropImage) {
    $stmt = $conn->prepare("INSERT INTO crop (Crop_Name, Crop_Unit, Crop_Price, Crop_Image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $cropName, $cropUnit, $cropPrice, $cropImage);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function deleteCrop($conn, $cropId) {
    $stmt = $conn->prepare("DELETE FROM crop WHERE Crop_ID = ?");
    $stmt->bind_param("i", $cropId);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function updateCropPrice($conn, $cropId, $newPrice) {
    $stmt = $conn->prepare("UPDATE crop SET Crop_Price = ? WHERE Crop_ID = ?");
    $stmt->bind_param("di", $newPrice, $cropId);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $name = $_POST['veg-name'];
                $unit = $_POST['veg-unit'];
                $price = $_POST['veg-price'];

                $image = $_FILES['veg-image']['name'];
                $imageTmp = $_FILES['veg-image']['tmp_name'];
                $imagePath = 'uploads/' . uniqid() . '_' . $image;

                if (!is_dir('uploads')) {
                    mkdir('uploads', 0755, true);
                }

                if (move_uploaded_file($imageTmp, $imagePath)) {
                    if (insertCrop($conn, $name, $unit, $price, $imagePath)) {
                        $_SESSION['message'] = "New crop inserted successfully";
                    } else {
                        $_SESSION['error'] = "Error: Unable to insert crop.";
                    }
                } else {
                    $_SESSION['error'] = "Image upload failed.";
                }
                break;

            case 'delete':
                if (isset($_POST['crop_id'])) {
                    $cropId = $_POST['crop_id'];
                    if (deleteCrop($conn, $cropId)) {
                        $_SESSION['message'] = "Crop deleted successfully";
                    } else {
                        $_SESSION['error'] = "Error: Unable to delete crop.";
                    }
                }
                break;

            case 'update':
                if (isset($_POST['crop_id']) && isset($_POST['new_price'])) {
                    $cropId = $_POST['crop_id'];
                    $newPrice = $_POST['new_price'];
                    if (updateCropPrice($conn, $cropId, $newPrice)) {
                        $_SESSION['message'] = "Crop price updated successfully";
                    } else {
                        $_SESSION['error'] = "Error: Unable to update crop price.";
                    }
                }
                break;
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$sql = "SELECT * FROM crop";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Market Price</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="market.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header class="header">
        <a href="#" class="logo">Market Price</a>
        <nav class="navbar">
            <a href="#all-product">Products</a>
        </nav>
    </header>

    <main class="main-content">
        <!-- Display messages or errors -->
        <?php
        session_start();
        if (isset($_SESSION['message'])) {
            echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        }
        if (isset($_SESSION['error'])) {
            echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
        ?>

        <div class="table-header">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search vegetables..." onkeyup="searchVegetables()">
            </div>
            <button class="btn btn-primary" onclick="toggleAddNewProduct()">
                <i class="fas fa-plus"></i>
                Add New Product
            </button>
        </div>












        <div class="vegetable-table">
            <table id="vegetable-table">
                <thead>
                    <tr>
                        <th>Vegetable</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display crops from the database
                    if ($result->num_rows > 0) {
                        $result->data_seek(0); // Reset result pointer for table data
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr data-crop-id='" . $row['Crop_ID'] . "'>";
                            echo "<td>" . htmlspecialchars($row['Crop_Name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Crop_Unit']) . "</td>";
                            echo "<td>$" . number_format($row['Crop_Price'], 2) . "</td>";
                            echo "<td><img src='" . htmlspecialchars($row['Crop_Image']) . "' alt='" . htmlspecialchars($row['Crop_Name']) . "' width='50' height='50' style='border-radius: 8px; object-fit: cover;'></td>";
                            echo "<td>
                                    <div class='action-buttons'>
                                        <button class='btn-icon btn-view' onclick='viewVegetable(this)'>
                                            <i class='fas fa-eye'></i>
                                        </button>
                                        <button class='btn-icon btn-edit' onclick='editPrice(this)'>
                                            <i class='fas fa-edit'></i>
                                        </button>
                                        <button class='btn-icon btn-delete' onclick='deleteVegetable(this)'>
                                            <i class='fas fa-trash'></i>
                                        </button>
                                    </div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No products available.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>






        <!-- Existing main content -->
        <div class="chart-container" style="width: 80%; margin: 2rem auto;">
            <canvas id="vegetableChart"></canvas>
        </div>









    </main>

    <!-- Add New Product Modal -->
    <div id="modal-overlay"></div>
    <div id="add-product-modal" class="modal">
        <div class="modal-content">
            <button class="close" onclick="toggleAddNewProduct()">&times;</button>
            <h2 style="margin-bottom: 1.5rem; color: var(--text);">Add New Vegetable</h2>
            <form id="new-vegetable-form" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <div class="form-group">
                    <label for="veg-name">Vegetable Name</label>
                    <input type="text" id="veg-name" name="veg-name" placeholder="Enter vegetable name" required>
                </div>

                <div class="form-group">
                    <label for="veg-unit">Unit</label>
                    <input type="text" id="veg-unit" name="veg-unit" placeholder="e.g., 1 KG" required>
                </div>

                <div class="form-group">
                    <label for="veg-price">Price</label>
                    <input type="number" id="veg-price" name="veg-price" step="0.01" placeholder="Enter price" required>
                </div>

                <div class="form-group">
                    <label for="veg-image">Image</label>
                    <input type="file" id="veg-image" name="veg-image" accept="image/*" required>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                    Add Vegetable
                </button>
            </form>
        </div>
    </div>

    <!-- View Vegetable Modal -->
    <div id="view-modal" class="modal">
        <div class="modal-content">
            <button class="close" onclick="closeModal()">&times;</button>
            <h2 id="modal-name" style="margin-bottom: 1rem;"></h2>
            <img id="modal-image" src="" alt="Vegetable Image"
                style="max-width: 200px; max-height: 200px; border-radius: 8px; margin-bottom: 1rem;">
            <p id="modal-price" style="font-size: 1.25rem; color: var(--text);"></p>
        </div>
    </div>

    <!-- Edit Price Modal -->
    <div id="edit-modal" class="modal">
        <div class="modal-content">
            <button class="close" onclick="closeModal()">&times;</button>
            <h2 style="margin-bottom: 1.5rem;">Edit Price</h2>
            <form id="edit-price-form" method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" id="edit-crop-id" name="crop_id">
                <div class="form-group">
                    <label for="edit-price">New Price</label>
                    <input type="number" id="edit-price" name="new_price" step="0.01" placeholder="Enter new price" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Save</button>
            </form>
        </div>
    </div>

    <script>
        // Toggle Add Product Form
        function toggleAddNewProduct() {
            const modal = document.getElementById('add-product-modal');
            const overlay = document.getElementById('modal-overlay');
            const isVisible = modal.style.display === 'block';

            modal.style.display = isVisible ? 'none' : 'block';
            overlay.style.display = isVisible ? 'none' : 'block';

            if (!isVisible) {
                document.getElementById('new-vegetable-form').reset();
            }
        }

        // View Vegetable
        function viewVegetable(button) {
            const row = button.closest('tr');
            const name = row.cells[0].textContent;
            const price = row.cells[2].textContent;
            const image = row.cells[3].querySelector('img').src;

            document.getElementById('modal-name').textContent = name;
            document.getElementById('modal-price').textContent = price;
            document.getElementById('modal-image').src = image;
            document.getElementById('view-modal').style.display = 'block';
            document.getElementById('modal-overlay').style.display = 'block';
        }

        // Edit Price
        function editPrice(button) {
            const row = button.closest('tr');
            const cropId = row.getAttribute('data-crop-id');
            const currentPrice = row.cells[2].textContent.replace('$', '');
            
            document.getElementById('edit-crop-id').value = cropId;
            document.getElementById('edit-price').value = currentPrice;
            document.getElementById('edit-modal').style.display = 'block';
            document.getElementById('modal-overlay').style.display = 'block';
        }

        // Delete Vegetable
        function deleteVegetable(button) {
            const row = button.closest('tr');
            const cropId = row.getAttribute('data-crop-id');
            
            if (confirm('Are you sure you want to delete this item?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="crop_id" value="${cropId}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Close Modal
        function closeModal() {
            document.getElementById('view-modal').style.display = 'none';
            document.getElementById('edit-modal').style.display = 'none';
            document.getElementById('modal-overlay').style.display = 'none';
        }

        // Search Vegetables
        function searchVegetables() {
            const input = document.querySelector('.search-input');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('vegetable-table');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const name = rows[i].getElementsByTagName('td')[0];
                if (name) {
                    const textValue = name.textContent || name.innerText;
                    if (textValue.toLowerCase().indexOf(filter) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        }

        // Close modal when clicking outside
        window.onclick = function (event) {
            const modals = document.getElementsByClassName('modal');
            const overlay = document.getElementById('modal-overlay');

            if (event.target === overlay) {
                for (let modal of modals) {
                    modal.style.display = 'none';
                }
                overlay.style.display = 'none';
            }
        }





        // Get data from PHP for the chart
        const chartData = <?php echo json_encode($chartData); ?>;

        // Extract labels (vegetable names) and data (prices) from chartData
        const labels = chartData.map(item => item.Crop_Name);
        const data = chartData.map(item => item.Crop_Price);

        // Initialize the Chart
        const ctx = document.getElementById('vegetableChart').getContext('2d');
        const vegetableChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Price (USD)',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Price (USD)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Vegetables'
                        }
                    }
                }
            }
        });






    </script>
</body>
</html>

<?php
$conn->close();
?>