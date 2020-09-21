<?php

namespace App\Repository;

use DB;
use Carbon\Carbon;
use Exception;

class Antrian
{
    protected $dbsimrs = "sql_simrs";

    public function postAntrian($params)
    {
        $dataPasien = $this->getDataPasien($params->nomorkartu);
        $dataPoli = $this->getDataPoli($params->kodepoli); // blum di kasih handle null

        $dataPasien->no_telp = $params->notelp;
        $dataPasien->nik = $params->nik;
        $dataPasien->kd_sub_unit = $dataPoli->kd_sub_unit;
        $dataPasien->tgl_reg = $params->tanggalperiksa;
        $dataPasien->waktu = date('H:i:s');
        $dataPasien->kd_cara_bayar = "8";
        $dataPasien->no_rujukan =  $params->jenisreferensi;
        $dataPasien->jenis_rujukan =  $params->jenisreferensi;
        $dataPasien->polieksekutif =  $params->polieksekutif;
        dd($dataPasien);
       
    }

    private function getDataPasien($nomorKartu)
    {
        return DB::connection($this->dbsimrs)->table('penjamin_pasien')->select('no_rm','no_kartu')
                ->where('no_kartu', $nomorKartu)->first();
    }

    private function getDataPoli($kodePoli)
    {
        return DB::connection($this->dbsimrs)->table('sub_unit')->select('kd_sub_unit')
                ->where('kd_poli_dpjp')->first();
    }
}
