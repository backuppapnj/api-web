<?php

/**
 * Public entry point for Lumen
 */

// SECURITY: Remove PHP version exposure
header_remove('X-Powered-By');

// SECURITY: Force HTTPS redirect in production
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
    $_SERVER['HTTPS'] = ($_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ? 'on' : 'off';
}

// Lazy loading autoloader
$app = require __DIR__ . '/../bootstrap/app.php';

$app->run();
