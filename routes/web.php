<?php

/** @var \Laravel\Lumen\Routing\Router $router */

// Health check
$router->get('/', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API Panggilan Ghaib PA Penajam'
    ]);
});

// SECURITY: Public routes dengan rate limiting (100 request/menit)
$router->group(['prefix' => 'api', 'middleware' => 'throttle:100,1'], function () use ($router) {
    // Panggilan Ghaib
    $router->get('panggilan', 'PanggilanController@index');
    $router->get('panggilan/{id:[0-9]+}', 'PanggilanController@show');
    $router->get('panggilan/tahun/{tahun:[0-9]+}', 'PanggilanController@byYear');

    // Itsbat Nikah
    $router->get('itsbat', 'ItsbatNikahController@index');
    $router->get('itsbat/{id:[0-9]+}', 'ItsbatNikahController@show');

    // Panggilan e-Court
    $router->get('panggilan-ecourt', 'PanggilanEcourtController@index');
    $router->get('panggilan-ecourt/{id:[0-9]+}', 'PanggilanEcourtController@show');
    $router->get('panggilan-ecourt/tahun/{tahun:[0-9]+}', 'PanggilanEcourtController@byYear');

    // Agenda Pimpinan
    $router->get('agenda', 'AgendaPimpinanController@index');
    $router->get('agenda/{id:[0-9]+}', 'AgendaPimpinanController@show');

    // LHKPN Routes
    $router->get('lhkpn', 'LhkpnController@index');
    $router->get('lhkpn/{id:[0-9]+}', 'LhkpnController@show');

    // Realisasi Anggaran Routes
    $router->get('anggaran', 'RealisasiAnggaranController@index');
    $router->get('anggaran/{id:[0-9]+}', 'RealisasiAnggaranController@show');
    $router->get('pagu', 'PaguAnggaranController@index');

    // DIPA POK Routes
    $router->get('dipapok', 'DipaPokController@index');
    $router->get('dipapok/{id:[0-9]+}', 'DipaPokController@show');
});

// SECURITY: Protected routes dengan API Key + rate limiting (100 request/menit)
$router->group(['prefix' => 'api', 'middleware' => ['api.key', 'throttle:100,1']], function () use ($router) {
    // Panggilan Ghaib
    $router->post('panggilan', 'PanggilanController@store');
    $router->put('panggilan/{id:[0-9]+}', 'PanggilanController@update');
    $router->post('panggilan/{id:[0-9]+}', 'PanggilanController@update');
    $router->delete('panggilan/{id:[0-9]+}', 'PanggilanController@destroy');

    // Itsbat Nikah
    $router->post('itsbat', 'ItsbatNikahController@store');
    $router->put('itsbat/{id:[0-9]+}', 'ItsbatNikahController@update');
    $router->post('itsbat/{id:[0-9]+}', 'ItsbatNikahController@update');
    $router->delete('itsbat/{id:[0-9]+}', 'ItsbatNikahController@destroy');

    // Panggilan e-Court
    $router->post('panggilan-ecourt', 'PanggilanEcourtController@store');
    $router->put('panggilan-ecourt/{id:[0-9]+}', 'PanggilanEcourtController@update');
    $router->post('panggilan-ecourt/{id:[0-9]+}', 'PanggilanEcourtController@update');
    $router->delete('panggilan-ecourt/{id:[0-9]+}', 'PanggilanEcourtController@destroy');

    // Agenda Pimpinan
    $router->post('agenda', 'AgendaPimpinanController@store');
    $router->put('agenda/{id:[0-9]+}', 'AgendaPimpinanController@update');
    $router->post('agenda/{id:[0-9]+}', 'AgendaPimpinanController@update');
    $router->delete('agenda/{id:[0-9]+}', 'AgendaPimpinanController@destroy');

    // LHKPN
    $router->post('lhkpn', 'LhkpnController@store');
    $router->put('lhkpn/{id:[0-9]+}', 'LhkpnController@update');
    $router->post('lhkpn/{id:[0-9]+}', 'LhkpnController@update');
    $router->delete('lhkpn/{id:[0-9]+}', 'LhkpnController@destroy');

    // Realisasi Anggaran
    $router->post('anggaran', 'RealisasiAnggaranController@store');
    $router->put('anggaran/{id:[0-9]+}', 'RealisasiAnggaranController@update');
    $router->delete('anggaran/{id:[0-9]+}', 'RealisasiAnggaranController@destroy');

    // Pagu Anggaran
    $router->post('pagu', 'PaguAnggaranController@store');
    $router->delete('pagu/{id:[0-9]+}', 'PaguAnggaranController@destroy');

    // DIPA POK
    $router->post('dipapok', 'DipaPokController@store');
    $router->put('dipapok/{id:[0-9]+}', 'DipaPokController@update');
    $router->post('dipapok/{id:[0-9]+}', 'DipaPokController@update');
    $router->delete('dipapok/{id:[0-9]+}', 'DipaPokController@destroy');
});