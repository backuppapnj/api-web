<?php

/** @var \Laravel\Lumen\Routing\Router $router */

// Health check
$router->get('/', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API Panggilan Ghaib PA Penajam'
        // SECURITY: Tidak expose versi di production
    ]);
});

// SECURITY: Public routes dengan rate limiting (100 request/menit)
$router->group(['prefix' => 'api', 'middleware' => 'throttle:100,1'], function () use ($router) {
    $router->get('panggilan', 'PanggilanController@index');
    $router->get('panggilan/{id:[0-9]+}', 'PanggilanController@show');
    $router->get('panggilan/tahun/{tahun:[0-9]+}', 'PanggilanController@byYear');

    // Itsbat Nikah Routes
    $router->get('itsbat', 'ItsbatNikahController@index');
    $router->get('itsbat/{id:[0-9]+}', 'ItsbatNikahController@show');
});

// SECURITY: Protected routes dengan API Key + rate limiting ketat (30 request/menit)
$router->group(['prefix' => 'api', 'middleware' => ['api.key', 'throttle:30,1']], function () use ($router) {
    $router->post('panggilan', 'PanggilanController@store');
    $router->put('panggilan/{id:[0-9]+}', 'PanggilanController@update');
    $router->delete('panggilan/{id:[0-9]+}', 'PanggilanController@destroy');

    // Itsbat Nikah Routes
    $router->post('itsbat', 'ItsbatNikahController@store');
    $router->put('itsbat/{id:[0-9]+}', 'ItsbatNikahController@update');
    $router->delete('itsbat/{id:[0-9]+}', 'ItsbatNikahController@destroy');
});
