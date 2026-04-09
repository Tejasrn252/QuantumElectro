<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$orders = [];

$stmt = $conn->prepare("SELECT id, total_price, utr, status, created_at, cart_data FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $items = json_decode($row['cart_data'], true);
    $row['item_count'] = is_array($items) ? count($items) : 0;
    $orders[] = $row;
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Orders - QuantumElectro</title>
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
          <li><a href="my-orders.php" class="active">My Orders</a></li>
          <li><a href="contact.html">Contact</a></li>
          <li><a href="profile.php" class="btn-login">Profile</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="orders-page">
    <div class="container">
      <section class="orders-card">
        <h2>My Orders</h2>
        <p class="orders-subtitle">Track your order history and status in one place.</p>

        <?php if (count($orders) === 0): ?>
          <div class="orders-empty">No orders yet. Start shopping to see your orders here.</div>
        <?php else: ?>
          <div class="orders-grid">
            <?php foreach ($orders as $order): ?>
              <article class="order-item">
                <div class="order-top">
                  <div>
                    <h3>Order #<?php echo htmlspecialchars($order['id']); ?></h3>
                    <p class="order-date"><?php echo htmlspecialchars($order['created_at']); ?></p>
                  </div>
                  <span class="status-chip <?php echo 'status-' . htmlspecialchars($order['status']); ?>"><?php echo htmlspecialchars(ucfirst($order['status'])); ?></span>
                </div>

                <div class="order-meta">
                  <div><strong>Total:</strong> Rs <?php echo htmlspecialchars($order['total_price']); ?></div>
                  <div><strong>UTR:</strong> <?php echo htmlspecialchars($order['utr']); ?></div>
                  <div><strong>Items:</strong> <?php echo htmlspecialchars($order['item_count']); ?></div>
                </div>
              </article>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </section>
    </div>
  </main>

  <footer class="footer">
    <div class="container">
      <p>© 2025 QuantumElectro. All rights reserved.</p>
    </div>
  </footer>

  <script src="script.js"></script>
</body>
</html>
