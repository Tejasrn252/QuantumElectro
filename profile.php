<?php
session_start();
require_once('db.php');

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT username, email, phone, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $phone, $created_at);
$stmt->fetch();
$stmt->close();

$_SESSION['username'] = $username;
$_SESSION['email'] = $email;
$_SESSION['phone'] = $phone;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile - QuantumElectro</title>
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
          <li><a href="my-orders.php">My Orders</a></li>
          <li><a href="contact.html">Contact</a></li>
          <li><a href="profile.php" class="active">Profile</a></li>
          <li><a href="logout.php" class="btn-login">Logout</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="profile-page">
    <div class="container">
      <div class="profile-card">
        <h2>My Profile</h2>
        <p class="profile-subtitle">Welcome back, <?php echo htmlspecialchars($username); ?>.</p>

        <div class="profile-details">
          <div class="profile-row">
            <span class="label">Username</span>
            <span class="value"><?php echo htmlspecialchars($username); ?></span>
          </div>
          <div class="profile-row">
            <span class="label">Email</span>
            <span class="value"><?php echo htmlspecialchars($email); ?></span>
          </div>
          <div class="profile-row">
            <span class="label">Phone</span>
            <span class="value"><?php echo htmlspecialchars($phone ?? 'Not set'); ?></span>
          </div>
          <div class="profile-row">
            <span class="label">Joined</span>
            <span class="value"><?php echo htmlspecialchars($created_at); ?></span>
          </div>
        </div>

        <div class="profile-actions">
          <a href="my-orders.php" class="btn-primary">My Orders</a>
          <a href="products.html" class="btn-primary">Continue Shopping</a>
          <a href="logout.php" class="btn-logout">Logout</a>
        </div>
      </div>
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
