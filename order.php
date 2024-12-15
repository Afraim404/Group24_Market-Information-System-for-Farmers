<?php
// Start the session
session_start();

// Database connection details
$host = 'localhost';
$username = 'root';     // Change to your database username
$password = '';         // Change to your database password
$database = 'agribridge';

// Check if user is logged in as a customer
$customerName = "Guest";
$customerId = 0; // Default to 0 for guest users
if (isset($_SESSION['User_ID']) && $_SESSION['UserType'] === 'Customer') {
    $customerName = $_SESSION['Username'];
    $customerId = $_SESSION['User_ID'];
}

// Database connection
$mysqli = new mysqli($host, $username, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    die(json_encode([
        'success' => false, 
        'message' => 'Database connection failed: ' . $mysqli->connect_error
    ]));
}

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get JSON data
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // If JSON decoding fails
    if (!$data) {
        echo json_encode([
            'success' => false, 
            'message' => 'Invalid order data'
        ]);
        exit();
    }

    // Validate required fields
    $requiredFields = ['name', 'delivery_address', 'contact_number', 'cart', 'total_price'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            echo json_encode([
                'success' => false, 
                'message' => "Missing required field: $field"
            ]);
            exit();
        }
    }

    // Prepare order insert
    $stmt = $mysqli->prepare("INSERT INTO orders (user_id, name, delivery_address, contact_number, total_price, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("isssd", $customerId, $data['name'], $data['delivery_address'], $data['contact_number'], $data['total_price']);
    
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        // Prepare statement for order items
        $item_stmt = $mysqli->prepare("INSERT INTO order_item (order_id, product_name, price, quantity) VALUES (?, ?, ?, ?)");
        
        // Insert each item in the order
        foreach ($data['cart'] as $item) {
            $item_stmt->bind_param("isdi", $order_id, $item['name'], $item['price'], $item['quantity']);
            $item_stmt->execute();
        }

        // Close statements
        $stmt->close();
        $item_stmt->close();

        // Respond with success
        echo json_encode([
            'success' => true, 
            'message' => 'Order placed successfully!', 
            'order_id' => $order_id
        ]);
    } else {
        // Handle order insert error
        echo json_encode([
            'success' => false, 
            'message' => 'Error placing order: ' . $stmt->error
        ]);
    }

    // Close database connection
    $mysqli->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Your Order</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="order_style.css">
    <script defer src="order.js"></script>
</head>
<body>
    <header>
        <nav>
            <div class="nav-left">
                <img src="LogoNoBG.png" alt="agriBridge" class="nav-logo">
                <div class="search-bar">
                    <input type="text" id="search-input" placeholder="Search products...">
                    <button id="search-btn">🔍</button>
                </div>
            </div>
        </nav>
        <div class="icons">
            <a href="customer.php" class="fa fa-shopping-cart" id="cart-btn" title="Back to Shopping"></a>
        </div>
    </header>
    <main>
        <div class="order-container">
            <h1>Confirm Your Order</h1>
            <div class="order-summary" id="order-summary">
                <!-- Display the order summary dynamically with JS -->
            </div>

            <form method="POST" action="order.php">
                <div class="user-info">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($customerName) ?>" required><br>
                    
                    <label for="delivery-address">Delivery Address:</label>
                    <input type="text" id="delivery-address" name="delivery_address" placeholder="Enter your delivery address" required><br>
                    
                    <label for="contact-number">Contact Number:</label>
                    <input type="tel" id="contact-number" name="contact_number" placeholder="Enter your contact number" required><br>
                </div>

                <div class="total-price">
                    Total: $<span id="total-price">0.00</span>
                    <input type="hidden" name="total_price" id="total-price-input">
                </div>

                <button type="submit" name="confirm_order" class="confirm-btn">Confirm Order</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 agriBridge. All rights reserved.</p>
    </footer>

    <script>
        // Example cart data (you should use session/cart data here)
        const cartItems = [
            { product_name: "Potato", price: 29.99, quantity: 2 },
            { product_name: "Carrot", price: 19.99, quantity: 3 }
        ];

        // Display the cart items and total price
        const orderSummary = document.getElementById('order-summary');
        let totalPrice = 0;
        cartItems.forEach(item => {
            totalPrice += item.price * item.quantity;
            orderSummary.innerHTML += `<p>${item.product_name} x ${item.quantity} - $${(item.price * item.quantity).toFixed(2)}</p>`;
        });

        document.getElementById('total-price').innerText = totalPrice.toFixed(2);
        document.getElementById('total-price-input').value = totalPrice.toFixed(2);
    </script>
</body>
</html>
