<?php

namespace App\Http\Controllers\ApiSIMRS\Apm;

use App\Http\Controllers\Controller;
use App\Repository\Antrian;
use App\Repository\Registrasi;
use App\Transform\TransformRegistrasi;

class ApmController extends Controller
{
    protected $registrasi;
    protected $antrian;
    protected $transform;

    public function __construct()
    {
        $this->registrasi = new Registrasi;
        $this->antrian = new Antrian;
        $this->transform = new TransformRegistrasi;
    }

    public function dataRegistrasi($noRm)
    {
        $dataRegistrasi = $this->registrasi->dataRegistrasi($noRm);

        if (!$dataRegistrasi) {
            $error['messageError'] = "Data Registrasi pasien tidak ditemukan!!";
            return response()->jsonApi("201", $error['messageError']);
        }

        $dataAntrian = $this->antrian->dataAntrian($dataRegistrasi);
        $checkSKU = $this->registrasi->checkSuratKontrol($noRm, $dataRegistrasi->kd_poli_dpjp);
        $sku = $checkSKU == null ? '0' : '1';
        $transform = $this->transform->mapDataRegistrasi($dataRegistrasi, $dataAntrian, $sku);

        return response()->jsonApi("200", "OK", $transform);
    }

    public function dataSuratKontrol($code)
    {
        $dataSuratkontrol = $this->registrasi->dataSuratkontrol($code);
        if (!$dataSuratkontrol) {
            $error['messageError'] = "Code surat rencana kontrol tidak ditemukan!!";
            return response()->jsonApi("201", $error['messageError']);
        }

        $transform = $this->transform->mapDataSuratkontrol($dataSuratkontrol);
        return response()->jsonApi("200", "OK", $transform);
    }

    public function jumlahSep($jnsRujukan, $noRujukan)
    {
        //
    }

    public function insertSep(Request $request)
    {
        //
    }
}
