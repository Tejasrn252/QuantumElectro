<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "quantumelectro";

$conn = mysqli_connect($host, $user, $pass, $db_name);

// Check connection
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Handling the form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO contact (name, email, message) VALUES ('$name', '$email', '$message')";

    if (mysqli_query($conn, $sql)) {
        echo "✅ Message Sent Successfully!";
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
