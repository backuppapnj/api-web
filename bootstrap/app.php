<?php

require_once __DIR__ . '/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'Asia/Makassar'));

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();
$app->withEloquent();

// SECURITY: Global middleware yang berlaku untuk semua request
$app->middleware([
    App\Http\Middleware\CorsMiddleware::class,
]);

// SECURITY: Route-specific middleware
$app->routeMiddleware([
    'api.key' => App\Http\Middleware\ApiKeyMiddleware::class,
    'throttle' => App\Http\Middleware\RateLimitMiddleware::class,
]);

// Register Service Providers
$app->register(App\Providers\AppServiceProvider::class);

// SECURITY: Register Exception Handler for security headers on errors
$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

// Load Routes
$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__ . '/../routes/web.php';
});

return $app;
