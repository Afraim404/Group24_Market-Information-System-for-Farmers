document.addEventListener('DOMContentLoaded', () => {
    const orderSummary = document.getElementById('order-summary');
    const totalPriceElement = document.getElementById('total-price');

    // Fetch cart from localStorage
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    let totalPrice = 0;

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

        totalPrice += item.price * item.quantity;
    });

    totalPriceElement.textContent = totalPrice.toFixed(2);
});

// Update quantity and recalculate
function updateQuantity(productName, change) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const product = cart.find(item => item.name === productName);

    if (product) {
        product.quantity += change;
        if (product.quantity <= 0) {
            cart = cart.filter(item => item.name !== productName);
        }
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    location.reload(); // Refresh the page to reflect updates
}

// Confirm order
function confirmOrder() {
    alert('Thank you for your order!');
    localStorage.removeItem('cart');
    location.reload();
}
