<?php
require_once('db.php');

$success = false;
$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if(empty($username) || empty($email) || empty($phone) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif(!preg_match('/^[0-9]{10,15}$/', $phone)) {
      $error = "Phone number must be 10 to 15 digits.";
    } elseif(strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } elseif($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if email already exists
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();
        
        if($check_stmt->num_rows > 0) {
            $error = "Email already registered. <a href='login.php'>Login here →</a>";
        } else {
            // Hash the password securely
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare("INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $phone, $hashed_password);
            
            if($stmt->execute()){
                $success = true;
            } else {
                $error = "Registration failed. Please try again.";
            }
            $stmt->close();
        }
        $check_stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - QuantumElectro</title>
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
          <li><a href="login.php">Login</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main style="flex-grow: 1; display: flex; align-items: center; background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 50%, #fce7f3 100%);">
    <div class="container" style="width: 100%;">
      <div class="form-container">
        <h2>Join Us! 🎉</h2>
        
        <?php if($success): ?>
          <div class="success">
            ✅ Registration successful! Redirecting to login...
          </div>
          <script>
            setTimeout(function() {
              window.location.href = 'login.php';
            }, 2000);
          </script>
        <?php elseif(!empty($error)): ?>
          <div class="error">
            <strong>⚠️ Error:</strong> <?php echo $error; ?>
          </div>
        <?php endif; ?>

        <?php if(!$success): ?>
          <form method="post" action="register.php" autocomplete="off">
            <input type="text" name="username" placeholder="👤 Choose a username" required autocomplete="username">
            <input type="email" name="email" placeholder="📧 Enter your email" required autocomplete="email">
            <input type="tel" name="phone" placeholder="📱 Enter phone number" required pattern="[0-9]{10,15}" title="Enter 10 to 15 digits">
            <input type="password" name="password" placeholder="🔒 Create a password" required minlength="6">
            <input type="password" name="confirm_password" placeholder="🔒 Confirm password" required>
            <button type="submit">✨ Create Account</button>
          </form>

          <p>Already have an account? <a href="login.php">Login here →</a></p>
        <?php endif; ?>
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
