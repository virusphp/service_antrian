<?php

/*
|--------------------------------------------------------------------------
| Application Routes Antrian
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// ------------------- REGISTRASI POLIKLINIK MULTI PLATFORM BRIDGING MOBILE JKN V1
$router->group(['namespace' => 'ApiSIMRS', 'middleware' => 'bpjs'], function() use ($router) {    
    $router->post('/antrian/registrasi/via/bpjs', 'AntrianController@Register');
    $router->post('/antrian/getrekap', 'AntrianController@getRekapAntrian');
    $router->post('/operasi/getoperasi', 'OperationController@getOperasi');
    $router->post('/operasi/getjadwal', 'OperationController@getJadwal');

    // Registrasi POLIKINIK BRIDGING MOBILE JKN V2
    $router->group(['prefix' => 'bpjs'], function() use ($router) {
        $router->post('/antrian/registrasi', 'AntrianController@RegisterV2');
    });
});