<?php
// Start the session
session_start();

// Default values for guest
$customerName = "Guest";
$customerId = "None";

// Check if the user is logged in and is a Customer
if (isset($_SESSION['User_ID']) && $_SESSION['UserType'] === 'Customer') {
    // Retrieve customer details from session
    $customerName = $_SESSION['Username'];
    $customerId = $_SESSION['User_ID'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>agriBridge | Farmer Information System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="customer_style.css">
    <script defer src="customer.js"></script>
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
            <a href="order_graph.php" class="fa fa-chart-bar" id="menu-btn" title="Order Graph"></a>
            <a href="order.php" class="fa fa-shopping-cart" id="cart-btn" title="View Cart"></a>
            <div class="profile-icon">
                <div class="fa fa-user" id="profile-btn"></div>
                <div class="dropdown" id="profile-dropdown">
                    <p id="username">Name: Guest</p>
                    <p id="userid">ID: None</p>
                    <form method="POST" action="logout.php">
                        <button type="submit" id="signout-btn" class="dropdown-button">Sign Out</button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <main>
        <section id="hero" class="hero-section">
            <div class="hero-content">
                <h1>Fresh from the Farm to Your Doorstep<br>
                    <span class="highlight_h1">Real-Time Market Insights</span>
                </h1>
                <p>Welcome to agriBridge, your trusted platform for connecting with buyers,<br> tracking prices, and accessing resources to make informed farming decisions.</p>
                <a href="#market-prices" class="cta-button">Explore Now</a>
            </div>
        </section>
        <section class="feature-section" id="product-list">
            <div class="product-container" data-name="Potato">
                <img src="potatoes-7952746_1920.jpg" alt="Potato" class="product-img">
                <div class="product-title">Potato</div>
                <div class="product-price">$29.99</div>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-container" data-name="Carrot">
                <img src="carrots-1851424_1280.jpg" alt="Carrot" class="product-img">
                <div class="product-title">Carrot</div>
                <div class="product-price">$19.99</div>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-container" data-name="Bell Pepper">
                <img src="bell-peppers-499068_1280.jpg" alt="Bell Pepper" class="product-img">
                <div class="product-title">Bell Pepper</div>
                <div class="product-price">$24.99</div>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-container" data-name="Onion">
                <img src="onion-2404583_1280.jpg" alt="Onion" class="product-img">
                <div class="product-title">Onion</div>
                <div class="product-price">$20.99</div>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-container" data-name="Cucumber">
                <img src="vegetables-7937832_1280.jpg" alt="Cucumber" class="product-img">
                <div class="product-title">Cucumber</div>
                <div class="product-price">$15.99</div>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-container" data-name="Tomato">
                <img src="tomato-435867_1280.jpg" alt="Tomato" class="product-img">
                <div class="product-title">Tomato</div>
                <div class="product-price">$25.99</div>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 agriBridge. All rights reserved.</p>
    </footer>

    <script>
        // Embed PHP session data into JavaScript
        const customerName = <?php echo json_encode($customerName); ?>;
        const customerId = <?php echo json_encode($customerId); ?>;

        // Save these details into localStorage for use in JavaScript
        localStorage.setItem('customerName', customerName);
        localStorage.setItem('customerId', customerId);
    </script>
</body>
</html>