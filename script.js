document.addEventListener('DOMContentLoaded', () => {
    updateAuthNav();

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
        checkoutBtn.addEventListener('click', async () => {
            if (cart.length > 0) {
                try {
                    const response = await fetch('auth_status.php', {
                        method: 'GET',
                        credentials: 'same-origin'
                    });
                    const auth = await response.json();

                    if (auth.logged_in) {
                        // Store total price in localStorage
                        localStorage.setItem("quantumElectroTotal", getTotalAmount());
                        // Redirect to address page
                        window.location.href = "address.php";
                    } else {
                        alert('Please login before placing an order.');
                        window.location.href = 'login.php';
                    }
                } catch (_error) {
                    alert('Please login before placing an order.');
                    window.location.href = 'login.php';
                }
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

    function updateAuthNav() {
        const previousOrderCount = Number(localStorage.getItem('qeOrderCount') || 0);
        const celebrateOrderCount = localStorage.getItem('qeOrderCelebrate') === '1';
        if (celebrateOrderCount) {
            localStorage.removeItem('qeOrderCelebrate');
        }

        fetch('auth_status.php', {
            method: 'GET',
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(async data => {
            if (data.logged_in) {
                localStorage.setItem('qeUser', JSON.stringify(data));
                const orderCount = await fetchOrderCount();
                localStorage.setItem('qeOrderCount', String(orderCount));
                applyAuthNav(
                    data,
                    orderCount,
                    celebrateOrderCount ? Math.max(orderCount - 1, 0) : previousOrderCount
                );
            } else {
                localStorage.removeItem('qeUser');
                localStorage.removeItem('qeOrderCount');
            }
        })
        .catch(() => {
            const cached = localStorage.getItem('qeUser');
            if (cached) {
                try {
                    const user = JSON.parse(cached);
                    const cachedCount = Number(localStorage.getItem('qeOrderCount') || 0);
                    applyAuthNav(
                        user,
                        cachedCount,
                        celebrateOrderCount ? Math.max(cachedCount - 1, 0) : previousOrderCount
                    );
                } catch (_error) {
                    localStorage.removeItem('qeUser');
                    localStorage.removeItem('qeOrderCount');
                }
            }
        });
    }

    function applyAuthNav(data, orderCount = 0, previousOrderCount = 0) {
        const navLists = document.querySelectorAll('.nav ul');

        navLists.forEach(nav => {
            const loginLink = nav.querySelector('a[href="login.php"]');
            const registerLink = nav.querySelector('a[href="register.php"]');
            const profileLink = nav.querySelector('a[href="profile.php"]');
            const myOrdersLink = nav.querySelector('a[href="my-orders.php"]');
            const logoutLink = nav.querySelector('a[href="logout.php"]');

            if (registerLink) {
                const registerLi = registerLink.closest('li');
                if (registerLi) {
                    registerLi.remove();
                }
            }

            const targetLink = loginLink || profileLink;
            let targetLi = targetLink ? targetLink.closest('li') : null;

            if (!targetLi) {
                targetLi = document.createElement('li');
                nav.appendChild(targetLi);
            }

            const displayName = escapeHtml(data.username || 'User');
            const displayEmail = escapeHtml(data.email || 'Not set');
            const displayPhone = escapeHtml(data.phone || 'Not set');
            const avatarInitial = escapeHtml((data.username || 'U').trim().charAt(0).toUpperCase() || 'U');

            targetLi.classList.add('profile-menu');
            targetLi.innerHTML = `
                <a href="profile.php" class="btn-login profile-trigger">Hi, ${escapeHtml(data.username || 'User')}</a>
                <div class="profile-dropdown">
                    <div class="profile-card-top">
                        <div class="profile-avatar">${avatarInitial}</div>
                        <div class="profile-card-meta">
                            <div class="profile-name">${displayName}</div>
                            <div class="profile-state"><span class="profile-dot"></span>Online</div>
                        </div>
                    </div>
                    <div class="profile-info-grid">
                        <div class="profile-info-row">
                            <span class="profile-k">Email</span>
                            <span class="profile-v">${displayEmail}</span>
                        </div>
                        <div class="profile-info-row">
                            <span class="profile-k">Phone</span>
                            <span class="profile-v">${displayPhone}</span>
                        </div>
                    </div>
                    <div class="profile-dropdown-actions">
                        <a href="my-orders.php">My Orders</a>
                        <a href="profile.php">View Profile</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            `;

            if (!myOrdersLink) {
                const myOrdersLi = document.createElement('li');
                myOrdersLi.className = 'dynamic-orders-link';
                myOrdersLi.innerHTML = '<a href="my-orders.php" class="btn-orders"><span class="orders-label">My Orders</span><span class="orders-badge" hidden>0</span><span class="orders-orbit" hidden></span></a>';

                const profileMenuLi = nav.querySelector('.profile-menu');
                if (profileMenuLi) {
                    nav.insertBefore(myOrdersLi, profileMenuLi);
                } else {
                    nav.appendChild(myOrdersLi);
                }
            } else {
                myOrdersLink.classList.add('btn-orders');
                if (!myOrdersLink.querySelector('.orders-label')) {
                    const currentText = myOrdersLink.textContent.trim() || 'My Orders';
                    myOrdersLink.innerHTML = '<span class="orders-label"></span><span class="orders-badge" hidden>0</span><span class="orders-orbit" hidden></span>';
                    myOrdersLink.querySelector('.orders-label').textContent = currentText;
                }
            }

            const ordersLink = nav.querySelector('a[href="my-orders.php"]');
            if (ordersLink) {
                updateOrdersBadge(ordersLink, orderCount, previousOrderCount);
            }

            if (logoutLink) {
                const logoutLi = logoutLink.closest('li');
                if (logoutLi && logoutLi !== targetLi) {
                    logoutLi.remove();
                }
            }
        });
    }

    function updateOrdersBadge(linkEl, count, previousCount = 0) {
        const labelEl = linkEl.querySelector('.orders-label');
        const badgeEl = linkEl.querySelector('.orders-badge');
        const orbitEl = linkEl.querySelector('.orders-orbit');

        if (!labelEl || !badgeEl || !orbitEl) {
            return;
        }

        labelEl.textContent = 'My Orders';

        if (count > 0) {
            badgeEl.hidden = false;
            orbitEl.hidden = false;
            badgeEl.textContent = count > 99 ? '99+' : String(count);
            linkEl.classList.add('has-orders');

            if (count > previousCount) {
                linkEl.classList.add('order-celebrate');
                badgeEl.classList.add('badge-burst');
                window.setTimeout(() => {
                    linkEl.classList.remove('order-celebrate');
                    badgeEl.classList.remove('badge-burst');
                }, 900);
            }
        } else {
            badgeEl.hidden = true;
            orbitEl.hidden = true;
            linkEl.classList.remove('has-orders');
        }
    }

    async function fetchOrderCount() {
        try {
            const response = await fetch('orders_count.php', {
                method: 'GET',
                credentials: 'same-origin'
            });
            const payload = await response.json();
            if (payload && payload.logged_in) {
                return Number(payload.count || 0);
            }
        } catch (_error) {
            // Keep fallback count if request fails.
        }
        return Number(localStorage.getItem('qeOrderCount') || 0);
    }

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }
});
