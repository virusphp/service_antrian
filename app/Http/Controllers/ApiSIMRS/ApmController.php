<?php

namespace App\Http\Controllers\ApiSIMRS;

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

        if (!$dataRegistrasi)  {
            $error['messageError'] = "Data Registrasi pasien tidak ditemukan!!";
            return response()->jsonApi(201, $error['messageError']);
        }

        $dataAntrian = $this->antrian->dataAntrian($dataRegistrasi);

        $transform = $this->transform->mapDataRegistrasi($dataRegistrasi, $dataAntrian);

        return response()->jsonApi(200, "OK", $transform);
    }

}