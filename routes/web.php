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

    // Panggilan e-Court Routes
    $router->get('panggilan-ecourt', 'PanggilanEcourtController@index');
    $router->get('panggilan-ecourt/{id:[0-9]+}', 'PanggilanEcourtController@show');
    $router->get('panggilan-ecourt/tahun/{tahun:[0-9]+}', 'PanggilanEcourtController@byYear');

    // Agenda Pimpinan Routes
    $router->get('agenda', 'AgendaPimpinanController@index');
    $router->get('agenda/{id:[0-9]+}', 'AgendaPimpinanController@show');

    // LHKPN Routes
    $router->get('lhkpn', 'LhkpnController@index');
    $router->post('lhkpn', 'LhkpnController@store');
    $router->get('lhkpn/{id:[0-9]+}', 'LhkpnController@show');
    $router->put('lhkpn/{id:[0-9]+}', 'LhkpnController@update');
    $router->delete('lhkpn/{id:[0-9]+}', 'LhkpnController@destroy');

    // Realisasi Anggaran Routes
    $router->get('anggaran', 'RealisasiAnggaranController@index');
    $router->get('anggaran/{id:[0-9]+}', 'RealisasiAnggaranController@show');
    $router->get('pagu', 'PaguAnggaranController@index');
});

// SECURITY: Protected routes dengan API Key + rate limiting (100 request/menit)
$router->group(['prefix' => 'api', 'middleware' => ['api.key', 'throttle:100,1']], function () use ($router) {
    // ... (existing codes)
    $router->post('anggaran', 'RealisasiAnggaranController@store');
    $router->put('anggaran/{id:[0-9]+}', 'RealisasiAnggaranController@update');
    $router->delete('anggaran/{id:[0-9]+}', 'RealisasiAnggaranController@destroy');

    $router->post('pagu', 'PaguAnggaranController@store');
    $router->delete('pagu/{id:[0-9]+}', 'PaguAnggaranController@destroy');
});
