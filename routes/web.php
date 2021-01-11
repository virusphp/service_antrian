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

// ----------------- REGISTRASI ACCESS SSO MULTI APP BY SCOPE
$router->group(['namespace'  => 'ApiSSO'], function() use ($router) {
    $router->post('/access/register', 'RegistrasiPlatrofmController@Register');
    $router->post('/access/login', 'LoginPlatformController@Login');
});

// ------------------- REGISTRASI POLIKLINIK MULTI PLATFORM
$router->group(['namespace' => 'ApiSIMRS', 'middleware' => 'bpjs'], function() use ($router) {    
    $router->post('/antrian/registrasi/via/bpjs', 'AntrianController@Register');
    $router->post('/antrian/getrekap', 'AntrianController@getRekapAntrian');
    $router->post('/operasi/getoperasi', 'OperationController@getOperasi');
    $router->post('/operasi/getjadwal', 'OperationController@getJadwal');
});

// ----------------------- API BPJS FROM INTERNAL
$router->group(['namespace' => 'BridgingBPJS'], function() use ($router) {
    // ----------------- REFERENSI --------------------------//
    $router->get('/referensi/diagnosa/{kode}', 'ReferensiController@diagnosa');
    $router->get('/referensi/poli/{kode}', 'ReferensiController@poli');
    $router->get('/referensi/faskes/{kodeNama}/{jenisFaskes}', 'ReferensiController@faskes');
    $router->get('/referensi/dokter/pelayanan/{jnsPel}/tglpelayanan/{tglPel}/spesialis/{subSpesial}', 'ReferensiController@dpjp');
    // Location
    $router->get('/referensi/propinsi', 'ReferensiController@propinsi');
    $router->get('/referensi/kabupaten/propinsi/{kodePropinsi}', 'ReferensiController@kabupaten');
    $router->get('/referensi/kecamatan/kabupaten/{kodeKabupaten}', 'ReferensiController@kecamatan');
    // End location
    $router->get('/referensi/procedure/{kodeNama}', 'ReferensiController@procedure');
    $router->get('/referensi/kelasrawat', 'ReferensiController@kelas');
    $router->get('/referensi/dokter/{namaDokter}', 'ReferensiController@dokter');
    $router->get('/referensi/spesialistik', 'ReferensiController@spesialistik');
    $router->get('/referensi/ruangrawat', 'ReferensiController@ruang');
    $router->get('/referensi/carakeluar', 'ReferensiController@caraKeluar');
    $router->get('/referensi/pascapulang', 'ReferensiController@pascaPulang');

    // -------------------- PESERTA -----------------------------//
    $router->get('/peserta/nokartu/{noKartu}/tglsep/{tglSep}', 'PesertaController@noKartu');
    $router->get('/peserta/nik/{nik}/tglsep/{tglSep}', 'PesertaController@noKtp');

    // ---------------------- RUJUKAN ----------------------------//
    $router->get('/rujukan/{noRujukan}', 'RujukanController@RujukanPcare');
    $router->get('/rujukan/rs/{noRujukan}', 'RujukanController@RujukanRs');
    $router->get('/rujukan/peserta/{noKartu}', 'RujukanController@PesertaPcare');
    $router->get('/rujukan/rs/peserta/{noKartu}', 'RujukanController@PesertaRs');
    $router->get('/rujukan/list/peserta/{noKartu}', 'RujukanController@PesertaListPcare');
    $router->get('/rujukan/rs/list/peserta/{noKartu}', 'RujukanController@PesertaListRs');

    // --------------------- Monitoring ----------------------------//
    $router->get('/monitoring/kunjungan/tanggal/{tglSep}/jnspelayanan/{jnsPel}', 'MonitoringController@Kunjungan');
    $router->get('/monitoring/klaim/tanggal/{tglPulang}/jnspelayanan/{jnsPel}/status/{status}', 'MonitoringController@Klaim');
    $router->get('/monitoring/historipelayanan/nokartu/{noKartu}/tglawal/{tglAwal}/tglakhir/{tglAkhir}', 'MonitoringController@History');
    $router->get('/monitoring/jasaraharja/tglawal/{tglAwal}/tglakhir/{tglAkhir}', 'MonitoringController@JasaRaharja');

    // ---------------------- SEP ---------------------------------//
    $router->get('/sep/{noSep}', 'SepController@CariSep');

});

// ----------------- API BRIDGING BANK JATENG
$router->group(['namespace'  => 'ApiBankJateng', 'middleware' => 'bankjateng'], function() use ($router) {
    $router->post('/tagihan/pasien', 'TagihanController@getTagihanPasien');
    $router->post('/tagihan/bayartagihan', 'BankJatengController@bayarTagihan');
});