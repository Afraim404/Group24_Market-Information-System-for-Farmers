document.addEventListener('DOMContentLoaded', () => {
    // Selectors for search and product features
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-btn');
    const productContainers = document.querySelectorAll('.product-container');

    // Selectors for profile dropdown
    const profileBtn = document.getElementById('profile-btn');
    const profileDropdown = document.getElementById('profile-dropdown');
    const usernameElement = document.getElementById('username');
    const useridElement = document.getElementById('userid');
    const signoutButton = document.getElementById('signout-btn');

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

    /**
     * Toggle profile dropdown visibility.
     */
    const toggleProfileDropdown = () => {
        profileDropdown.classList.toggle('visible');
    };

    /**
     * Sign out functionality.
     */
    const signOut = () => {
        alert('You have been signed out.');
        localStorage.removeItem('customerName');
        localStorage.removeItem('customerId');
        window.location.href = 'login.html'; // Redirect to login page
    };

    /**
     * Initialize user details.
     */
    const initializeUserDetails = () => {
        // Retrieve user details from localStorage
        const customerName = localStorage.getItem('customerName') || 'Guest';
        const customerId = localStorage.getItem('customerId') || 'None';

        // Update the DOM elements with user details
        if (usernameElement) {
            usernameElement.textContent = `Name: ${customerName}`;
        }
        if (useridElement) {
            useridElement.textContent = `ID: ${customerId}`;
        }
    };

    // Attach event listeners to "Add to Cart" buttons
    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => addToCart(button));
    });

    // Attach event listeners for search bar functionality
    searchInput.addEventListener('input', filterProducts); // Real-time filtering
    searchButton.addEventListener('click', filterProducts); // Manual filtering via button click

    // Attach event listeners for profile dropdown
    profileBtn.addEventListener('click', toggleProfileDropdown);

    // Prevent errors if signoutButton does not exist in DOM
    if (signoutButton) {
        signoutButton.addEventListener('click', signOut);
    }

    // Initialize user details
    if (usernameElement && useridElement) {
        initializeUserDetails();
    }
});
