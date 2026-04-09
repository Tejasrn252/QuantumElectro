<?php
session_start();
require_once('db.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
  $stmt = $conn->prepare("SELECT id, username, email, phone, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows > 0){
    $stmt->bind_result($id, $username, $user_email, $user_phone, $hashed_password);
        $stmt->fetch();
        if(password_verify($password, $hashed_password)){
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
      $_SESSION['email'] = $user_email;
      $_SESSION['phone'] = $user_phone;
      header("Location: profile.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that email.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - QuantumElectro</title>
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
          <li><a href="contact.html">Contact</a></li>
          <li><a href="register.php">Register</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main style="flex-grow: 1; display: flex; align-items: center; background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 50%, #fce7f3 100%);">
    <div class="container" style="width: 100%;">
      <div class="form-container">
        <h2>Welcome Back! 👋</h2>
        
        <?php if(isset($error)): ?>
          <div class="error">
            <strong>⚠️ Error:</strong> <?php echo htmlspecialchars($error); ?>
          </div>
        <?php endif; ?>

        <form method="post" action="login.php" autocomplete="off">
          <input type="email" name="email" placeholder="📧 Enter your email" required autocomplete="email">
          <input type="password" name="password" placeholder="🔒 Enter your password" required>
          <button type="submit">🚀 Login Now</button>
        </form>

        <p>Don't have an account? <a href="register.php">Create one here →</a></p>
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
