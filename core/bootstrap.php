<?php
ini_set('display_errors', '0');
ini_set('log_errors', '1');
set_exception_handler(function ($error) {
    error_log($error->getMessage());
    http_response_code(500);
    exit('The website cannot complete this request. Check the server log or setup instructions.');
});
$configFile = __DIR__ . '/../config.local.php';
if (!is_file($configFile)) {
    http_response_code(503);
    exit('Setup required: copy config.example.php to config.local.php and import the database.');
}
$config = require $configFile;
if (PHP_SAPI !== 'cli') {
    $secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    if ($config['https_required'] && !$secure) {
        http_response_code(403);
        exit('Please access this website using HTTPS.');
    }
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    session_name('jester_session');
    session_set_cookie_params(['httponly' => true, 'secure' => $secure, 'samesite' => 'Lax']);
    session_start();
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Cache-Control: no-store');
}
$db = new PDO('mysql:host=' . $config['host'] . ';port=' . $config['port'] . ';dbname=' . $config['database'] . ';charset=utf8mb4', $config['user'], $config['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]);
require_once __DIR__ . '/helpers.php';
