let searchForm = document.querySelector('.search-form');
document.querySelector('#search-btn').onclick = () => {
    searchForm.classList.toggle('active');
};

// Sample data for the products
const vegetables = [
    { id: 1, name: "Garlic", price: 300, unit: "1 KG", img: "garlic.jpg" },
    { id: 2, name: "Cucumber", price: 120, unit: "1 KG", img: "cucumber.jpg" },
    { id: 3, name: "Onion", price: 150, unit: "1 KG", img: "onion.jpg" },
    { id: 4, name: "Cabbage", price: 30, unit: "1 KG", img: "cabbage.jpg" },
    { id: 5, name: "Tomato", price: 200, unit: "1 KG", img: "tomato.jpg" },
    { id: 6, name: "Cauliflower", price: 50, unit: "1 PCS", img: "cauliflower.jpg" },
    { id: 7, name: "Potato", price: 70, unit: "1 KG", img: "potato.jpg" },
    { id: 8, name: "Lemon", price: 40, unit: "4 PCS", img: "lemon.jpg" },
    { id: 9, name: "Lady's Finger", price: 80, unit: "1 KG", img: "ladysfinger.jpg" },
    { id: 10, name: "Eggplant", price: 100, unit: "1 KG", img: "eggplant.jpg" },
    { id: 11, name: "Radish", price: 80, unit: "1 KG", img: "radish.jpg" },
    { id: 12, name: "Spinach", price: 60, unit: "1 PCS", img: "spinach.jpg" },
];

// Function to display products in the table
function displayProducts(products) {
    const tableBody = document.getElementById('table-body');
    tableBody.innerHTML = ''; // Clear the table
    products.forEach(product => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${product.id}</td>
            <td>${product.name}</td>
            <td>${product.price}</td>
            <td>${product.unit}</td>
            <td>
                <button onclick="viewCrop(${product.id})">View</button>
                <button onclick="editCrop(${product.id})">Edit</button>
                <button onclick="deleteRow(${product.id})">Delete</button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Function to search vegetables by name
function searchVegetable() {
    const searchQuery = document.getElementById('search-box').value.toLowerCase();
    const filteredProducts = vegetables.filter(product => 
        product.name.toLowerCase().includes(searchQuery)
    );
    displayProducts(filteredProducts);
}

// Function to view crop details
function viewCrop(id) {
    const product = vegetables.find(v => v.id === id);
    if (product) {
        const cropInfo = `
            <h2>${product.name}</h2>
            <img src="${product.img}" alt="${product.name}" style="width: 200px; height: auto;">
            <p>Price: ${product.price}</p>
            <p>Unit: ${product.unit}</p>
        `;
        const cropInfoDiv = document.getElementById("crop-info");
        cropInfoDiv.innerHTML = cropInfo;
        cropInfoDiv.style.display = "block";
    } else {
        alert("Crop not found!");
    }
}

// Function to edit crop price
function editCrop(id) {
    const product = vegetables.find(v => v.id === id);
    if (product) {
        const newPrice = prompt(`Edit price for ${product.name}`, product.price);
        if (newPrice && !isNaN(newPrice)) {
            product.price = parseFloat(newPrice);
            displayProducts(vegetables);
            alert(`Price updated to ${newPrice}`);
        } else {
            alert("Invalid price entered!");
        }
    }
}

// Function to delete a row
function deleteRow(id) {
    const index = vegetables.findIndex(v => v.id === id);
    if (index > -1 && confirm(`Are you sure you want to delete ${vegetables[index].name}?`)) {
        vegetables.splice(index, 1);
        displayProducts(vegetables);
        alert("Row deleted!");
    }
}

function addNewProduct() {
    // Get form values
    const name = document.getElementById('product-name').value.trim();
    const price = parseFloat(document.getElementById('product-price').value.trim());
    const unit = document.getElementById('product-unit').value.trim();
    const img = document.getElementById('product-image').value.trim();

    // Validate inputs
    if (!name || isNaN(price) || !unit) {
        alert('Please fill out all required fields correctly!');
        return;
    }

    // Generate a new ID for the product
    const newId = vegetables.length > 0 ? vegetables[vegetables.length - 1].id + 1 : 1;

    // Add the new product to the array
    const newProduct = { id: newId, name, price, unit, img: img || 'default.jpg' };
    vegetables.push(newProduct);

    // Update the table
    displayProducts(vegetables);

    // Reset the form and hide the section
    document.getElementById('new-product-form').reset();
    document.getElementById('add-new-product').style.display = 'none';

    alert(`Product "${name}" added successfully!`);
}

function toggleAddNewProduct() {
    const formSection = document.getElementById('add-new-product');
    formSection.style.display = formSection.style.display === 'none' ? 'block' : 'none';
}

function scrollToTable() {
    const tableSection = document.getElementById('product-table');
    tableSection.scrollIntoView({ behavior: 'smooth' });
}
