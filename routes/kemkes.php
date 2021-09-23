<?php

/*
|--------------------------------------------------------------------------
| Application Routes Kemkes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// ----------------- API BRIDGING SIRS ONLINE
$router->group(['namespace'  => 'ApiKemkes'], function() use ($router) {
    // Api Referensi
    $router->get('/referensi/tempattidur', 'ReferensiController@referensiTempatTidur');
    $router->get('/referensi/usiameninggal', 'ReferensiController@referensiUsiaMeninggal');
    $router->get('/referensi/kebutuhansdm', 'ReferensiController@referensiKebutuhanSDM');
    $router->get('/referensi/kebutuhanapd', 'ReferensiController@referensiKebutuhanAPD');

    //  Api Tempat tidur
    $router->get('/fasyankes/list/tempattidur', 'BedController@getTempatTidur');
    $router->post('/fasyankes/post/tempattidur', 'BedController@postTempatTidur');
    $router->delete('/fasyankes/delete/tempattidur', 'BedController@deleteTempatTidur');

    // Api Rekap Pasien 
    $router->get('/laporan/list/pasienmasuk', 'RekapPasienController@getPasienMasuk');
    $router->post('/laporan/post/pasienmasuk', 'RekapPasienController@postPasienMasuk');

    $router->get('/laporan/list/pasiendirawatkomorbid', 'RekapPasienController@getPasienKomorbid');
    $router->post('/laporan/post/pasiendirawatkomorbid', 'RekapPasienController@postPasienKomorbid');

    $router->get('/laporan/list/pasiendirawattanpakomorbid', 'RekapPasienController@getPasienTanpaKomorbid');
    $router->post('/laporan/post/pasiendirawattanpakomorbid', 'RekapPasienController@postPasienTanpaKomorbid');

    $router->get('/laporan/list/pasienkeluar', 'RekapPasienController@getPasienKeluar');
    $router->post('/laporan/post/pasienkeluar', 'RekapPasienController@postPasienKeluar');

    // Api SDM
    $router->get('/list/sdm', 'SdmController@getSDM');
    $router->post('/post/sdm', 'SdmController@postSDM');
    $router->put('/put/sdm', 'SdmController@updateSDM');
    $router->delete('/delete/sdm', 'SdmController@deleteSDM');

     // Api APD
     $router->get('/list/apd', 'ApdController@getAPd');
     $router->post('/post/apd', 'ApdController@postAPD');
     $router->put('/put/apd', 'ApdController@updateAPD');
     $router->delete('/delete/apd', 'ApdController@deleteAPD');

    // GANTI PASSWORD SIRS
    $router->post('/profil/ganti/password', 'ProfilController@updatePassword');
});