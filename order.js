document.addEventListener('DOMContentLoaded', () => {
    const orderSummary = document.getElementById('order-summary');
    const totalPriceElement = document.getElementById('total-price');
    const confirmButton = document.querySelector('.confirm-btn');
    const nameInput = document.getElementById('name');
    const addressInput = document.getElementById('delivery-address');
    const contactInput = document.getElementById('contact-number');

    // Fetch cart from localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    /**
     * Recalculate the total price.
     * @returns {number} The total price of the items in the cart.
     */
    const calculateTotalPrice = () => {
        return cart.reduce((total, item) => total + item.price * item.quantity, 0).toFixed(2);
    };

    /**
     * Render the cart items in the order summary.
     */
    const renderCart = () => {
        orderSummary.innerHTML = ''; // Clear existing content

        cart.forEach(item => {
            const productRow = document.createElement('div');
            productRow.className = 'product-item';

            productRow.innerHTML = `
                <span class="product-name">${item.name}</span>
                <div class="product-quantity">
                    <button class="quantity-btn" onclick="updateQuantity('${item.name}', -1)">-</button>
                    <span>${item.quantity}</span>
                    <button class="quantity-btn" onclick="updateQuantity('${item.name}', 1)">+</button>
                </div>
                <span class="product-price">$${(item.price * item.quantity).toFixed(2)}</span>
            `;

            orderSummary.appendChild(productRow);
        });

        // Update total price
        totalPriceElement.textContent = calculateTotalPrice();
    };

    /**
     * Update product quantity in the cart.
     * @param {string} productName - The name of the product.
     * @param {number} change - Quantity change (+1 or -1).
     */
    window.updateQuantity = (productName, change) => {
        const product = cart.find(item => item.name === productName);

        if (product) {
            product.quantity += change;
            if (product.quantity <= 0) {
                cart = cart.filter(item => item.name !== productName); // Remove product from cart
            }
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart(); // Re-render cart items
    };

    /**
     * Handle order confirmation.
     */
    const confirmOrder = () => {
        const name = nameInput.value.trim();
        const address = addressInput.value.trim();
        const contact = contactInput.value.trim();

        if (!name || !address || !contact) {
            alert('Please fill in all the required fields.');
            return;
        }

        // Prepare order data
        const orderData = {
            name,
            delivery_address: address,
            contact_number: contact,
            cart,
            total_price: calculateTotalPrice()
        };

        // Send order data to backend
        fetch('order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(orderData)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message || 'Thank you for your order!');
                    localStorage.removeItem('cart');
                    window.location.href = 'customer.php'; // Redirect to customer page
                } else {
                    alert(data.message || 'An error occurred while placing the order.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again later.');
            });
    };

    // Attach event listener for the confirm button
    confirmButton.addEventListener('click', confirmOrder);

    // Initialize the cart display
    renderCart();
});
