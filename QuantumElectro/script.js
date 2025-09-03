document.addEventListener('DOMContentLoaded', () => {
    const cartKey = 'quantumElectroCart';
    let cart = JSON.parse(localStorage.getItem(cartKey)) || [];

    // Conversion rate: 1 USD = 83 INR (adjust as needed)
    const USD_TO_INR_RATE = 83;

    // Add to Cart Functionality
    const addToCartButtons = document.querySelectorAll('.btn-add-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const productId = e.target.getAttribute('data-id');
            const productCard = e.target.closest('.product-card');
            const productName = productCard.querySelector('.product-name').textContent;
            let productPrice = productCard.querySelector('.product-price').textContent;
            const productImg = productCard.querySelector('.product-img').src;

            // Convert price to a numeric value and handle both rupee and dollar formats
            let basePrice = parseFloat(productPrice.replace(/[^0-9.-]+/g, ''));
            if (productPrice.includes('$')) {
                basePrice *= USD_TO_INR_RATE; // Convert USD to INR
            }
            productPrice = `₹${basePrice.toFixed(2)}`;

            // Check if the product is already in the cart
            const existingItem = cart.find(item => item.id === productId);
            if (existingItem) {
                existingItem.quantity = (existingItem.quantity || 1) + 1;
            } else {
                cart.push({ id: productId, name: productName, price: productPrice, img: productImg, quantity: 1 });
            }

            localStorage.setItem(cartKey, JSON.stringify(cart));
            alert(`${productName} added to cart!`);
        });
    });

    // Display Cart
    const cartContainer = document.getElementById('cart-container');
    const cartItemsContainer = document.getElementById('cart-items');
    const cartTotalElement = document.getElementById('cart-total');

    if (cartContainer && cartItemsContainer && cartTotalElement) {
        updateCartDisplay();

        // Checkout Functionality - Redirect to address/payment page if cart is not empty
        const checkoutBtn = document.getElementById('checkout-btn');
        checkoutBtn.addEventListener('click', () => {
            if (cart.length > 0) {
                // Store total price in localStorage
                localStorage.setItem("quantumElectroTotal", getTotalAmount());
                // Redirect to address page
                window.location.href = "address.php";
            } else {
                alert('Your cart is empty!');
            }
        });
    }

    function updateCartDisplay() {
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<p class="empty-cart">Your cart is empty.</p>';
            cartTotalElement.textContent = '₹0';
            localStorage.setItem("quantumElectroTotal", "0");
        } else {
            let cartHtml = '';
            let total = 0;

            cart.forEach((item, index) => {
                // Extract numeric value from stored price (already in INR)
                const itemPrice = parseFloat(item.price.replace(/[^0-9.-]+/g, ''));
                const itemTotal = itemPrice * (item.quantity || 1);
                total += itemTotal;

                cartHtml += `
                    <div class="cart-item" data-index="${index}">
                        <img src="${item.img}" alt="${item.name}" class="cart-item-img">
                        <div class="cart-item-details">
                            <h3 class="cart-item-name">${item.name}</h3>
                            <p class="cart-item-price">${item.price} x ${item.quantity || 1}</p>
                            <button class="btn-remove-cart" data-index="${index}">Remove</button>
                        </div>
                    </div>
                `;
            });

            cartItemsContainer.innerHTML = cartHtml;
            cartTotalElement.textContent = `₹${total.toFixed(2)}`;

            // Store total amount in localStorage
            localStorage.setItem("quantumElectroTotal", total.toFixed(2));

            // Add event listeners to remove buttons
            const removeButtons = document.querySelectorAll('.btn-remove-cart');
            removeButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    const index = e.target.getAttribute('data-index');
                    cart.splice(index, 1);
                    localStorage.setItem(cartKey, JSON.stringify(cart));
                    updateCartDisplay();
                });
            });
        }
    }

    function getTotalAmount() {
        return localStorage.getItem("quantumElectroTotal") || "0";
    }

    // Checkout Page Handling
    if (document.getElementById('total-amount')) {
        document.getElementById("total-amount").textContent = `₹${getTotalAmount()}`;
        document.getElementById("total-input").value = getTotalAmount();
        document.getElementById("cart-data").value = localStorage.getItem(cartKey) || "[]";
    }

    // Contact Form Submission
    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            alert('Your message has been sent successfully!');
        });
    }
});
