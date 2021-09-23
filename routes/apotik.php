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
    $router->get('/referensi/satuan', 'SatuanController@getSatuan');
});