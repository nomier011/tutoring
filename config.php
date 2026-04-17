<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'bsit_tutoring_db');

define('PAYMONGO_SECRET_KEY', '');
define('PAYMONGO_PUBLIC_KEY', '');
define('PAYMONGO_BASE_URL', 'https://api.paymongo.com/v1');

define('PAYMENT_METHODS', ['gcash', 'paymaya', 'grab_pay', 'qrph', 'cash']);

define('SITE_URL', 'http://localhost/bsit/');

define('UPLOAD_PATH', __DIR__ . '/uploads/');

if (!file_exists(UPLOAD_PATH)) {
    mkdir(UPLOAD_PATH, 0777, true);
}

function getConnection() {
    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conn;
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirect($url) {
    header("Location: " . $url);
    exit();
}

function setFlash($message, $type = 'success') {
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function getUserById($id) {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}
?>