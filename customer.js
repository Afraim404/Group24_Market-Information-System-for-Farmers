document.addEventListener('DOMContentLoaded', () => {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-btn');
    const productContainers = document.querySelectorAll('.product-container');

    /**
     * Add product to cart.
     */
    const addToCart = (button) => {
        const productContainer = button.closest('.product-container');
        const productName = productContainer.dataset.name;
        const productPrice = parseFloat(productContainer.querySelector('.product-price').textContent.replace('$', ''));

        // Retrieve the cart from localStorage or initialize an empty array
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Check if the product is already in the cart
        const existingProduct = cart.find(item => item.name === productName);
        if (existingProduct) {
            existingProduct.quantity += 1; // Increase quantity if product exists
        } else {
            cart.push({ name: productName, price: productPrice, quantity: 1 }); // Add new product
        }

        // Save the updated cart to localStorage
        localStorage.setItem('cart', JSON.stringify(cart));

        // Provide user feedback
        alert(`${productName} has been added to your cart!`);
    };

    /**
     * Filter products based on the search term.
     */
    const filterProducts = () => {
        const searchTerm = searchInput.value.toLowerCase(); // Convert search term to lowercase
        productContainers.forEach(container => {
            const productName = container.dataset.name.toLowerCase(); // Match case-insensitively
            if (productName.includes(searchTerm)) {
                container.style.display = 'block'; // Show matching products
            } else {
                container.style.display = 'none'; // Hide non-matching products
            }
        });
    };

    // Attach event listeners to "Add to Cart" buttons
    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => addToCart(button));
    });

    // Attach event listeners for search bar functionality
    searchInput.addEventListener('input', filterProducts); // Real-time filtering
    searchButton.addEventListener('click', filterProducts); // Manual filtering via button click
});
