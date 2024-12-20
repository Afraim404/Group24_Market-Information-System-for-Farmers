<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Seller Directory</title>
    <link rel="stylesheet" href="buyer_seller.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <!-- Header -->
    <header class="main-header">
        <img src="img/LogoNoBG.png" alt="agriBridge" class="nav-logo">

        <nav class="nav-links">
            <a href="index.html">Home</a>
            <a href="market-prices.html">Market Prices</a>
            <a href="finance.html">Finance</a>
            <a href="buyer_seller.php">Buyer Seller Directory</a>
            <a href="resources.html">Resources</a>
            <a href="contact.html">Contact Us</a>
        </nav>
        <div class="nav-buttons">
            <button class="nav-button">Login</button>
            <button class="nav-button">Sign Up</button>
        </div>
    </header><br/>

     <!-- Search & Filter Section -->
<div class="container my-4">
    <div class="card p-3 shadow-sm">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" id="searchNameProduct" class="form-control" placeholder="Search by name or product...">
            </div>
            <div class="col-md-3">
                <select id="filterCategory" class="form-select">
                    <option value="">All Categories</option>
                    <option value="Vegetables">Vegetables</option>
                    <option value="Fish">Fish</option>
                    <option value="Grains">Grains</option>
                    <option value="Fruits">Fruits</option>
                    <option value="Dairy">Dairy</option>
                    <option value="Oil">Oil</option>
                    <option value="Poultry">Poultry</option>
                    <option value="Meat">Meat</option>
                    <option value="Condiments">Condiments</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="filterLocation" class="form-select">
                    <option value="">All Location</option>
                    <option value="Dhaka">Dhaka</option>
                    <option value="Khulna">Khulna</option>
                    <option value="Rajshahi">Rajshahi</option>
                    <option value="Barishal">Barishal</option>
                    <option value="Chittagong">Chittagong</option>
                    <option value="Rangpur">Rangpur</option>
                    <option value="Sylhet">Sylhet</option>
                    <option value="Mymensingh">Mymensingh</option>
                    <option value="Dinajpur">Dinajpur</option>
                </select>
            </div>
            <div class="col-md-2">
                <button id="filterButton" class="btn btn-success w-100">Search</button>
            </div>
        </div>
    </div>
</div>



     <!-- Hero Section -->
     <div class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 text-success">Seller Directory</h1>
            <p class="lead text-dark">Connect with reliable sellers in the agricultural market.</p><br/>
        </div>
    </div>

    <!-- Seller Directory Listings -->
    <div id="directoryListings" class="container my-5">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php
// Database connection credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agribridge";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch buyer-seller data
$sql = "SELECT seller_name, product_name, location, category, price, image_path,contact_link FROM seller_directory";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="<?php echo htmlspecialchars($row['image_path']); ?>" class="card-img-top" alt="Product Image" style="height: 300px; width: 100%; object-fit: cover;">
                <div class="card-body bg-dark text-light" style="border-radius: 0% 0% 7% 7%;">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['seller_name']); ?></h5>
                    <p class="card-text"><strong>Product:</strong> <?php echo htmlspecialchars($row['product_name']); ?></p>
                    <p class="card-text"><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                    <p class="card-text"><strong>Category:</strong> <?php echo htmlspecialchars($row['category'] ?? 'N/A'); ?></p>
                    <p class="card-text"><strong>Price:</strong> Taka <?php echo htmlspecialchars($row['price']); ?></p>
                    <p class="card-text"><strong>Contact info:</strong> <?php echo htmlspecialchars($row['contact_link']); ?></p>
                    <div class="card-footer text-center bg-dark">
                        <?php if (!empty($row['contact_link'])): ?>
                            <a href="mailto:<?php echo htmlspecialchars($row['contact_link']); ?>?subject=Inquiry about <?php echo urlencode($row['product_name']); ?>&body=<?php echo urlencode('Hello, I am interested to sell this product.'); ?>" class="btn btn-success btn-sm">Contact Seller</a>
                        <?php else: ?>
                            <p>Contact information not available.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo '<p class="text-center">No records found in the database.</p>';
}

?>

        </div>
    </div>   



<br/><br/>

    <!-- Buyer Directory Section -->
<div id="buyerDirectoryListings" class="container my-5">
<div class="container">
            <h1 class="display-4 text-success text-center">Buyer Directory</h1>
            <p class="lead text-dark text-center">Connect with reliable buyers in the agricultural market.</p><br/>
        </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php
        // SQL query to fetch buyer data
        $sql = "SELECT buyer_name, product_needed, location, category, budget, contact_info, profile_image_path FROM buyer_directory";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center bg-dark text-light">
                            <!-- Profile Image -->
                            <img 
                                src="<?php echo htmlspecialchars(!empty($row['profile_image_path']) ? $row['profile_image_path'] : 'img/default-profile.png'); ?>" 
                                alt="Profile Image"
                                class="rounded-circle mb-3"
                                style="width: 100px; height: 100px; object-fit: cover;">
                            
                            <!-- Buyer Details -->
                            <h5 class="card-title text-success"><?php echo htmlspecialchars($row['buyer_name']); ?></h5>
                            <p class="card-text"><strong>Product Needed:</strong> <?php echo htmlspecialchars($row['product_needed']); ?></p>
                            <p class="card-text"><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                            <p class="card-text"><strong>Category:</strong> <?php echo htmlspecialchars($row['category'] ?? 'N/A'); ?></p>
                            <p class="card-text"><strong>Budget:</strong> Taka <?php echo htmlspecialchars($row['budget']); ?></p>
                            <p class="card-text"><strong>Contact Info:</strong> <?php echo htmlspecialchars($row['contact_info']); ?></p>
                        </div>
                        <div class="card-footer text-center bg-dark">
                        <a href="mailto:<?php echo htmlspecialchars($row['contact_info']); ?>?subject=Inquiry about <?php echo urlencode($row['product_needed']); ?>&body=Hello, I am interested in your product." class="btn btn-success btn-sm">Contact Buyer</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p class="text-center">No buyers found in the database.</p>';
        }
        
        $conn->close();
        ?>
    </div>
</div>



    
    <div class="container my-5">
        <!-- How It Works Section -->
        <div class="section-header text-center">
            <h2 class="text-success">How It Works</h2>
            <p>Find verified buyers and sellers in the agricultural market.</p>
        </div>

        <div class="row">
            <!-- For Buyers Section -->
            <div class="col-md-6">
                <h3 class="text-success">For Buyers</h3>
                <ul class="list-group">
                    <li class="list-group-item bg-dark text-light mb-1 ">Find fresh produce, organic crops, and specialty products.</li>
                    <li class="list-group-item bg-dark text-light mb-1">Browse verified seller profiles and product listings.</li>
                    <li class="list-group-item bg-dark text-light mb-1">Filter sellers by product type, location, and price range.</li>
                    <li class="list-group-item bg-dark text-light">Contact sellers directly to place orders.</li>
                </ul>
            </div>

            <!-- For Sellers Section -->
            <div class="col-md-6">
                <h3 class="text-success">For Sellers</h3>
                <ul class="list-group">
                    <li class="list-group-item bg-dark text-light mb-1">List your products and reach a wider market.</li>
                    <li class="list-group-item bg-dark text-light mb-1">Showcase your farm or business with detailed product listings.</li>
                    <li class="list-group-item bg-dark text-light mb-1">Respond to buyer inquiries and grow your customer base.</li>
                    <li class="list-group-item bg-dark text-light">Gain visibility and build long-term relationships with buyers.</li>
                </ul>
            </div>
        </div>
    </div>


    <!-- Contact Section -->
    <div class="container text-center my-5">
        <h4>If you need assistance, feel free to contact us:</h4>
        <p>Email: <a href="mailto:asifuzzaman927@gmail.com">asifuzzaman927@gmail.com</a></p>
        <p>Phone: +88 01327 147458</p>
    </div>

    <!-- Footer -->
    <footer>
        <p>Need help? <a href="contact.html">Contact Support</a></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>




        <script>
document.getElementById('filterButton').addEventListener('click', () => {
    filterCards('#directoryListings'); // For seller
    filterCards('#buyerDirectoryListings'); // For buyer
});
function filterCards(containerId) {
    const searchNameProduct = document.getElementById('searchNameProduct').value.trim().toLowerCase();
    console.log('Search Input:', searchNameProduct);

    const filterCategory = document.getElementById('filterCategory').value.trim().toLowerCase();
    console.log('Filter Category:', filterCategory);

    const filterLocation = document.getElementById('filterLocation').value.trim().toLowerCase();
    console.log('Filter Location:', filterLocation);

    // Get all the cards in the specified container
    const cards = document.querySelectorAll(`${containerId} .col`);
    console.log(`Number of cards in ${containerId}:`, cards.length);

    cards.forEach((card, index) => {
        let cardTitle = '';
        let productText = '';
        let locationText = '';
        let categoryText = '';

        // Extract card details depending on container (Buyer or Seller)
        if (containerId === '#directoryListings') {
            // Seller Directory
            cardTitle = card.querySelector('.card-title')?.textContent.toLowerCase() || '';
            productText = card.querySelector('.card-text:nth-of-type(1)')?.textContent.toLowerCase() || '';
            locationText = card.querySelector('.card-text:nth-of-type(2)')?.textContent.toLowerCase() || '';
            categoryText = card.querySelector('.card-text:nth-of-type(3)')?.textContent.toLowerCase() || '';
        } else if (containerId === '#buyerDirectoryListings') {
            // Buyer Directory (adjust if needed)
            cardTitle = card.querySelector('.card-title')?.textContent.toLowerCase() || '';
            productText = card.querySelector('.card-text:nth-of-type(1)')?.textContent.toLowerCase() || '';
            locationText = card.querySelector('.card-text:nth-of-type(2)')?.textContent.toLowerCase() || '';
            categoryText = card.querySelector('.card-text:nth-of-type(3)')?.textContent.toLowerCase() || '';
        }

        // Matching logic
        const matchesSearch =
            !searchNameProduct ||
            cardTitle.includes(searchNameProduct) ||
            productText.includes(searchNameProduct);

        const matchesCategory =
            !filterCategory ||
            categoryText.includes(filterCategory);

        const matchesLocation =
            !filterLocation ||
            locationText.includes(filterLocation);

        // Display logic
        if (matchesSearch && matchesCategory && matchesLocation) {
            card.style.display = ''; // Show the card
            console.log(`Card ${index + 1} - Display: Shown`);
        } else {
            card.style.display = 'none'; // Hide the card
            console.log(`Card ${index + 1} - Display: Hidden`);
        }
    });
}



</script>



</body>

</html>
