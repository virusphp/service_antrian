<?php

/*
|--------------------------------------------------------------------------
| Application Routes Bpjs
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// ----------------------- API BPJS FOR INTERNAL
$router->group(['namespace' => 'BridgingBPJS'], function () use ($router) {
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
    $router->post('/sep/insert', 'SepController@InsertSep');
    $router->get('/sep/{noSep}', 'SepController@CariSep');
    $router->delete('/sep/delete', 'SepController@DeleteSep');
    $router->post('/sep/updtglplg', 'SepController@UpdatePlg');

    // ---------------------- Rujukan ---------------------------------//
    $router->delete('/rujukan/delete', 'RujukanController@DeleteRujukan');

    // ---------------------- SURAT KONTROL ---------------------------------//
    $router->get('/rencanakontrol/jadwalpraktekdokter/jnskontrol/{jnsKontrol}/kodepoli/{kodePoli}/tglrencanakontrol/{tglKontrol}', 'RencanaKontrolController@DataDokter');
    $router->get('/rencanakontrol/listspesialistik/jnskontrol/{jnsKontrol}/nomor/{nomor}/tglrencanakontrol/{tglKontrol}', 'RencanaKontrolController@DataPoli');
    $router->get('/rencanakontrol/listrencanakontrol/tglawal/{tglAwal}/tglakhir/{tglAkhir}/filter/{filter}', 'RencanaKontrolController@DataSuratkontrol');
    $router->get('/rencanakontrol/nosuratkontrol/{noSurat}', 'RencanaKontrolController@CariSurat');
    $router->get('/rencanakontrol/nosep/{noSep}', 'RencanaKontrolController@CariSep');
    $router->post('/rencanakontrol/delete', 'RencanaKontrolController@DeleteSurat');
    $router->post('/rencanakontrol/update', 'RencanaKontrolController@UpdateSurat');
    $router->post('/rencanakontrol/insert', 'RencanaKontrolController@InsertSurat');
});
