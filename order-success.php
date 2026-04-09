<?php
session_start();

if (!isset($_SESSION['order_success_name'])) {
    header('Location: products.html');
    exit();
}

$name = $_SESSION['order_success_name'];
$total = $_SESSION['order_success_total'];
$utr = $_SESSION['order_success_utr'];
$order_time = $_SESSION['order_success_time'];
$order_status = $_SESSION['order_success_status'] ?? 'confirmed';
$increment_badge = !empty($_SESSION['order_success_increment_badge']);

unset($_SESSION['order_success_name']);
unset($_SESSION['order_success_total']);
unset($_SESSION['order_success_utr']);
unset($_SESSION['order_success_time']);
unset($_SESSION['order_success_status']);
unset($_SESSION['order_success_increment_badge']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Success - QuantumElectro</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <header class="header">
    <div class="container">
      <h1 class="logo">QuantumElectro</h1>
      <nav class="nav">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="products.html">Products</a></li>
          <li><a href="profile.php">Hi, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Profile'); ?></a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="order-success-page">
    <div class="container">
      <section class="order-success-card">
        <div class="success-badge">Order Confirmed</div>
        <h2>Payment Received Successfully</h2>
        <p class="order-success-subtitle">Thank you, <?php echo htmlspecialchars($name); ?>. Your order is now being prepared.</p>

        <div class="order-meta-grid">
          <div class="order-meta-item">
            <span class="meta-label">Total Paid</span>
            <span class="meta-value">Rs <?php echo htmlspecialchars($total); ?></span>
          </div>
          <div class="order-meta-item">
            <span class="meta-label">UTR</span>
            <span class="meta-value"><?php echo htmlspecialchars($utr); ?></span>
          </div>
          <div class="order-meta-item">
            <span class="meta-label">Order Time</span>
            <span class="meta-value"><?php echo htmlspecialchars($order_time); ?></span>
          </div>
          <div class="order-meta-item">
            <span class="meta-label">Status</span>
            <span class="meta-value status-chip status-<?php echo htmlspecialchars($order_status); ?>"><?php echo htmlspecialchars(ucfirst($order_status)); ?></span>
          </div>
        </div>

        <div class="track-order-card">
          <h3>Track Your Order</h3>
          <p>We are packing your items now. You can check updates in your profile soon.</p>
          <div class="track-progress">
            <div class="progress-dot active"></div>
            <div class="progress-line"></div>
            <div class="progress-dot"></div>
            <div class="progress-line"></div>
            <div class="progress-dot"></div>
          </div>
          <div class="track-labels">
            <span>Confirmed</span>
            <span>Shipped</span>
            <span>Delivered</span>
          </div>
        </div>

        <div class="order-actions">
          <a href="products.html" class="btn-primary">Continue Shopping</a>
          <a href="my-orders.php" class="btn-primary">My Orders</a>
          <a href="profile.php" class="btn-submit">Go To Profile</a>
        </div>
      </section>
    </div>
  </main>

  <footer class="footer">
    <div class="container">
      <p>© 2025 QuantumElectro. All rights reserved.</p>
    </div>
  </footer>

  <script>
    (function() {
      const incrementBadge = <?php echo $increment_badge ? 'true' : 'false'; ?>;
      if (incrementBadge) {
        localStorage.setItem('qeOrderCelebrate', '1');
        const current = Number(localStorage.getItem('qeOrderCount') || 0);
        localStorage.setItem('qeOrderCount', String(current + 1));
      }
    })();
    localStorage.removeItem('quantumElectroCart');
    localStorage.removeItem('quantumElectroTotal');
  </script>
  <script src="script.js"></script>
</body>
</html>
