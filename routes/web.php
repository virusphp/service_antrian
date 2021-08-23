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
    $router->post('/access/login', 'LoginPlatformController@Login');
});

// -------------------------- API SIMRS
$router->group(['namespace'  => 'ApiSIMRS'], function() use ($router) {
    // API  UNTUK ANDROID 
    $router->group(['namespace' => 'Android'], function() use ($router) {
        $router->post('/registrasi/user/pasien', 'RegistrasiAndroidController@registrasiAndroid');
        $router->post('/login/user/pasien', 'LoginAndroidController@loginAndroid');

        $router->get('/list/poliklinik', 'TarifPoliklinikController@getListPoli');
        $router->get('/tarif/poliklinik/{kodePoli}', 'TarifPoliklinikController@getTarifPoli');
    });
    
    // API UNTUK APM ANJUNGAN MANDIRI
    $router->get('/data/registrasi/{noRm}', 'ApmController@dataRegistrasi');


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
});

// ------------------- REGISTRASI POLIKLINIK MULTI PLATFORM BRIDGING MOBILE JKN
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
    $router->post('/sep/insert', 'SepController@InsertSep');
    $router->get('/sep/{noSep}', 'SepController@CariSep');
    $router->delete('/sep/delete', 'SepController@DeleteSep');

    // ---------------------- SEP ---------------------------------//
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
