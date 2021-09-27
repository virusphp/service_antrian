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

// ------------------- APOTIK
$router->group(['namespace'  => 'ApiApotik', 'prefix' => 'apotik'], function() use ($router) { 
    $router->post('/referensi/satuan', 'SatuanController@getSatuan');
    $router->post('/referensi/kelompok', 'KelompokObatController@getKelompok');
    $router->post('/referensi/jenisobat', 'JenisObatController@getJenisObat');
    $router->post('/referensi/golonganobat', 'JenisObatController@getJenisObat');
    $router->post('/referensi/pabrik', 'PabrikController@getPabrik');
    $router->post('/referensi/generik', 'GenerikController@getGenerik');
    $router->post('/referensi/barang', 'BarangFarmasiController@getBarang');
});