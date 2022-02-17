<?php

namespace App\Http\Controllers\ApiSIMRS;

use App\Http\Controllers\BridgingBPJS\BpjsController;
use App\Repository\Pasien;
use App\Transform\TransformPasien;
use Vclaim\Bridging\BridgingBpjs;

class PasienController extends BpjsController
{
    protected $pasien;
    protected $bridging;
    protected $transform;

    public function __construct()
    {
        parent::__construct();
        $this->pasien = new Pasien;
        $this->transform = new TransformPasien;
        $this->bridging = new BridgingBpjs;
    }

    public function getBiodataPasien($noRm)
    {
        $biodataPasien = $this->pasien->getBiodataPasien($noRm);

        if (!$biodataPasien) {
            $error = [
                "messageError" => "Pasien Tersebut tidak di temukan!"
            ];
            return response()->jsonApi(201,  $error["messageError"]);
        }
        
        $profilBpjs = $this->handlePesertaBpjs($biodataPasien->no_kartu, date('Y-m-d'));
        $transform = $this->transform->mapperBiodata($biodataPasien, $profilBpjs);
        // dd($transform);
        return response()->jsonApi(200, "OK", $transform);
        
    }

    protected function handlePesertaBpjs($noKartu, $tanggal) 
    {
        $endpoint = 'Peserta/nokartu/'. $noKartu . "/tglSEP/" . $tanggal;
        $peserta = $this->bridging->getRequest($endpoint);
        $peserta = json_decode($peserta);
        $peserta->status = $peserta->response->peserta->statusPeserta->keterangan;
        $peserta->jenis_peserta = $peserta->response->peserta->jenisPeserta->keterangan;
        $peserta->nik = $peserta->response->peserta->nik;
        unset($peserta->metaData, $peserta->response);
        return $peserta;
    }

}