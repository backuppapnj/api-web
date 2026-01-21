<?php

/** @var \Laravel\Lumen\Routing\Router $router */

// Health check
$router->get('/', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API Panggilan Ghaib PA Penajam',
        'version' => '1.0.0'
    ]);
});

// Public routes (untuk Joomla - hanya GET)
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('panggilan', 'PanggilanController@index');
    $router->get('panggilan/{id}', 'PanggilanController@show');
    $router->get('panggilan/tahun/{tahun}', 'PanggilanController@byYear');
});

// Protected routes (untuk Admin - butuh API Key)
$router->group(['prefix' => 'api', 'middleware' => 'api.key'], function () use ($router) {
    $router->post('panggilan', 'PanggilanController@store');
    $router->put('panggilan/{id}', 'PanggilanController@update');
    $router->delete('panggilan/{id}', 'PanggilanController@destroy');
});
