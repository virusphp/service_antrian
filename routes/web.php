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

use Illuminate\Support\Facades\Hash;

$router->get('/buatpassword/{password}', function($password) {
    return Hash::make($password);
});

$router->get('/', function () {
    return view('welcome.api');
});

// ----------------- REGISTRASI ACCESS SSO MULTI APP BY SCOPE
$router->group(['namespace'  => 'ApiSSO'], function() use ($router) {
    $router->post('/access/register', 'RegistrasiPlatrofmController@Register');
    $router->post('access/login', 'LoginPlatformController@Login');

    // BRIDGING ANTREAN MOBILE JKN V2
    $router->group(['middleware' => 'ssobpjs', 'prefix' => 'bpjs'], function() use ($router) {
        $router->post('access/login', 'LoginPlatformController@LoginV2');
    });
});

// ----------------- API BRIDGING BANK JATENG
$router->group(['namespace'  => 'ApiSIMRS', 'middleware' => 'bankjateng'], function() use ($router) {
    $router->get('/tagihan/rj/gettagihan', 'TagihanController@getTagihanRJ');
    $router->get('/tagihan/ri/gettagihan', 'TagihanController@getTagihanRI');
    $router->get('/tagihan/rd/gettagihan', 'TagihanController@getTagihanRD');
});

$router->group(['namespace'  => 'ApiBankJateng', 'middleware' => 'bankjateng'], function() use ($router) {
    $router->post('/tagihan/bayartagihan', 'BankJatengController@bayarTagihan');
});