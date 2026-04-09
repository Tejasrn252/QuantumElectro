<?php
session_start(); // Start session if needed for authentication
require_once('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $name    = $_POST["name"];
    $address = $_POST["address"];
    $phone   = $_POST["phone"];
    $email   = $_POST["email"];
    $utr     = $_POST["utr"];
    $cart    = isset($_POST["cart"]) ? $_POST["cart"] : "[]"; // Get cart JSON
    $total   = isset($_POST["total"]) ? $_POST["total"] : "0"; // Get total amount
    $user_id = $_SESSION['user_id'];
    $status  = 'confirmed';

    // Insert order into the database
    $stmt = $conn->prepare("INSERT INTO orders (user_id, name, address, phone, email, utr, cart_data, total_price, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssds", $user_id, $name, $address, $phone, $email, $utr, $cart, $total, $status);

    if ($stmt->execute()) {
        $_SESSION['order_success_name'] = $name;
        $_SESSION['order_success_total'] = $total;
        $_SESSION['order_success_utr'] = $utr;
        $_SESSION['order_success_time'] = date('Y-m-d H:i:s');
        $_SESSION['order_success_status'] = $status;
        $_SESSION['order_success_increment_badge'] = true;
        header('Location: order-success.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuantumElectro - Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1 class="logo">QuantumElectro</h1>
            <nav class="nav">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="products.html">Products</a></li>
                    <li><a href="cart.html">Cart</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="profile.php">Hi, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Profile'); ?></a></li>
                        <li><a href="logout.php" class="btn-login">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php" class="btn-login">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="checkout-page">
        <section class="shipping-payment-container checkout-card">
            <h2>Shipping Address & Payment</h2>
            <p class="checkout-subtitle">Complete your details to place the order securely.</p>

            <form method="POST" action="address.php" class="checkout-form">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter full name" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="4" placeholder="House no, street, city, state, pincode" required></textarea>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="10 digit mobile number" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter active email" required>
                </div>

                <div class="checkout-summary">
                    <h3>Order Summary</h3>
                    <p><strong>Total Amount:</strong> <span id="total-amount">₹0</span></p>
                </div>

                <div class="checkout-payment">
                    <h3>Payment</h3>
                    <p>Scan this UPI QR code and then enter your UTR below.</p>
                    <div class="upi-qr-wrap">
                        <img src="images/upi-qr.jpg" alt="UPI QR Code" class="upi-qr-img">
                    </div>
                </div>

                <div class="form-group">
                    <label for="utr">Payment UTR (Transaction ID)</label>
                    <input type="text" id="utr" name="utr" placeholder="Example: 312456789876" required>
                </div>

                <input type="hidden" id="cart-data" name="cart">
                <input type="hidden" id="total-input" name="total">

                <button type="submit" class="btn-submit">Submit Order</button>
            </form>
        </section>
    </main>
    <footer class="footer">
        <div class="container">
            <p>© 2025 QuantumElectro. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Retrieve cart and total price from localStorage
        document.getElementById("cart-data").value = localStorage.getItem("quantumElectroCart");
        document.getElementById("total-amount").textContent = `₹${localStorage.getItem("quantumElectroTotal") || "0"}`;
        document.getElementById("total-input").value = localStorage.getItem("quantumElectroTotal") || "0";

    </script>
    <script src="script.js"></script>
</body>
</html>
