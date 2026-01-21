<?php

/**
 * Lumen - A PHP Framework For Web Artisans
 *
 * @package  Lumen
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__ . '/../public' . $uri)) {
    return false;
}

// SECURITY: Force HTTPS in production
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

// SECURITY: Remove PHP version from headers
header_remove('X-Powered-By');

require_once __DIR__ . '/bootstrap/app.php';

$app->run();
