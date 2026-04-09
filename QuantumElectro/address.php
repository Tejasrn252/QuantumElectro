<?php
session_start(); // Start session if needed for authentication

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

    // Database connection details
    $servername = "localhost";
    $username   = "root"; // Default for XAMPP
    $password   = ""; // Default password for XAMPP (change if needed)
    $dbname     = "quantumelectro"; // Your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert order into the database
    $stmt = $conn->prepare("INSERT INTO orders (name, address, phone, email, utr, cart_data, total_price) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssd", $name, $address, $phone, $email, $utr, $cart, $total);

    if ($stmt->execute()) {
        echo "<script>alert('Order placed successfully!'); localStorage.clear(); window.location.href='index.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
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
        </div>
    </header>
    <main>
        <section class="page-container address">
            <h2 class="section-title">Shipping Address & Payment</h2>
            <form method="POST" action="address.php" onsubmit="clearCart()">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <h3>Order Summary</h3>
                <p><strong>Total Amount:</strong> <span id="total-amount">₹0</span></p>

                <h3>Payment</h3>
                <div class="upi-payment">
                    <p>Scan the UPI QR code below to make the payment:</p>
                    <img src="images/upi-qr.jpg" alt="UPI QR Code" style="max-width: 200px;">
                </div>
                <div class="form-group">
                    <label for="utr">Enter Payment UTR (Transaction ID)</label>
                    <input type="text" id="utr" name="utr" required>
                </div>

                <!-- Hidden input to store cart data and total amount -->
                <input type="hidden" id="cart-data" name="cart">
                <input type="hidden" id="total-input" name="total">

                <button type="submit" class="btn-primary">Submit Order</button>
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

        // Clear cart after successful order submission
        function clearCart() {
            localStorage.removeItem("quantumElectroCart");
            localStorage.removeItem("quantumElectroTotal");
        }
    </script>
</body>
</html>
