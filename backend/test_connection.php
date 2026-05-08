<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'quantumelectro';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    echo "❌ Database Connection FAILED: " . $conn->connect_error;
} else {
    echo "✅ Database Connection SUCCESS!";
    echo "\n✅ Host: " . $host;
    echo "\n✅ User: " . $user;
    echo "\n✅ Database: " . $dbname;
    
    // Check if users table exists
    $result = $conn->query("SHOW TABLES LIKE 'users'");
    if($result && $result->num_rows > 0) {
        echo "\n✅ Users table EXISTS";
    } else {
        echo "\n⚠️  Users table NOT FOUND - Creating it...";
        $create_sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            phone VARCHAR(20) DEFAULT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        if($conn->query($create_sql)) {
            echo "\n✅ Users table CREATED successfully!";
        }
    }
}
$conn->close();
?>
