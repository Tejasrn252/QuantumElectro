<?php
// Root index.php - Entry point
// Redirect to frontend home page or handle routing

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base_path = '/QuantumElectro';

// Remove base path from URI
$path = str_replace($base_path, '', $uri);
$path = ltrim($path, '/');

// Routes to backend PHP files
$backend_routes = [
    'login' => 'backend/login.php',
    'register' => 'backend/register.php',
    'logout' => 'backend/logout.php',
    'profile' => 'backend/profile.php',
    'my-orders' => 'backend/my-orders.php',
    'checkout' => 'backend/address.php',
    'order-success' => 'backend/order-success.php',
    'contact' => 'backend/contact.php',
];

// Routes to frontend HTML files
$frontend_routes = [
    'products' => 'frontend/products.html',
    'cart' => 'frontend/cart.html',
    'contact-form' => 'frontend/contact.html',
];

// Handle API endpoints
if (strpos($path, 'api/') === 0) {
    $api = str_replace('api/', '', $path);
    $api = explode('?', $api)[0];
    
    if ($api === 'auth_status') {
        include 'backend/auth_status.php';
        exit;
    } elseif ($api === 'orders_count') {
        include 'backend/orders_count.php';
        exit;
    }
}

// Handle static files
if (preg_match('/\.(css|js|jpg|jpeg|png|gif|webp|svg)$/i', $path)) {
    $file = realpath($path);
    if ($file && file_exists($file)) {
        // Serve with appropriate headers
        $mimes = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
        ];
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (isset($mimes[$ext])) {
            header('Content-Type: ' . $mimes[$ext]);
        }
        readfile($file);
        exit;
    }
}

// Route handling
if (!empty($path)) {
    // Check backend routes
    foreach ($backend_routes as $route => $file) {
        if (strpos($path, $route) === 0) {
            include $file;
            exit;
        }
    }
    
    // Check frontend routes
    foreach ($frontend_routes as $route => $file) {
        if (strpos($path, $route) === 0) {
            include $file;
            exit;
        }
    }
}

// Default to home page
include 'frontend/index.html';
?>
