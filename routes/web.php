<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () {
    return view('welcome.api');
});

$router->group(['namespace' => 'BridgingBPJS'], function() use ($router) {
    $router->get('/referensi/diagnosa/{kode}', 'ReferensiController@diagnosa');
    $router->get('/referensi/poli/{kode}', 'ReferensiController@poli');
    $router->get('/referensi/faskes/{kodeNama}/{jenisFaskes}', 'ReferensiController@faskes');
    $router->get('/referensi/dokter/pelayanan/{jnsPel}/tglpelayanan/{tglPel}/spesialis/{subSpesial}', 'ReferensiController@dpjp');

    $router->get('/referensi/propinsi', 'ReferensiController@propinsi');
    $router->get('/referensi/kabupaten/propinsi/{kodePropinsi}', 'ReferensiController@kabupaten');
});