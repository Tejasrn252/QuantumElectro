<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'logged_in' => false,
        'count' => 0
    ]);
    exit();
}

require_once('db.php');

$user_id = $_SESSION['user_id'];
$count = 0;

$stmt = $conn->prepare("SELECT COUNT(*) FROM orders WHERE user_id = ?");
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
}

echo json_encode([
    'logged_in' => true,
    'count' => (int)$count
]);
?>
