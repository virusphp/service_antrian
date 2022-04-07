<?php

/*
|--------------------------------------------------------------------------
| Application Routes Simrs
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// -------------------------- API SIMRS
$router->group(['namespace'  => 'ApiSIMRS'], function () use ($router) {
    // API  UNTUK ANDROID
    $router->group(['namespace' => 'Android'], function () use ($router) {
        $router->post('/registrasi/user/pasien', 'RegistrasiAndroidController@registrasiAndroid');
        $router->post('/login/user/pasien', 'LoginAndroidController@loginAndroid');

        $router->get('/list/poliklinik', 'TarifPoliklinikController@getListPoli');
        $router->get('/tarif/poliklinik/{kodePoli}', 'TarifPoliklinikController@getTarifPoli');
    });

    //  TEMPAT TIDUR
    $router->get('/list/tempattidur/kemkes', 'KamarController@getListKamarKemkes');
    $router->get('/list/tempattidur/siranap', 'KamarController@getListKamarSiranap');
    $router->get('/list/tempattidur/siranap/xml', 'KamarController@getListKamarSiranapXml');

    $router->get('/pasien/biodata/norm/{noRm}', 'PasienController@getBiodataPasien');

    // DOKUMEN PASIEN
    $router->post('/pasien/dokumen/simpan', 'DokumenPasienController@simpanDokumen');
    $router->post('/pasien/dokumen/update', 'DokumenPasienController@updateDokumen');
    $router->post('/pasien/dokumen/delete', 'DokumenPasienController@deleteDokumen');
    $router->get('/pasien/dokumen/show/{idFile}', 'DokumenPasienController@showDokumen');

    // API UNTUK APM ANJUNGAN MANDIRI
    $router->group(['namespace' => 'Apm', 'prefix' => 'apm'], function () use ($router) {
        $router->get('/data/registrasi/{noRm}', 'ApmController@dataRegistrasi');
        $router->get('/data/suratkontrol/{code}', 'ApmController@dataSuratKontrol');
        $router->post('/sep/insert', 'ApmController@insertSep');
        // $router->post('/rujukaninternal', 'RujukanInternalController@getRujukanInternal');
    });
});
