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
        try {
            $simpan = $this->simpanRegistrasi($params);
        } catch (Exception $e) {
            $e->getMessage();
        }

    }

    private function simpanRegistrasi($params)
    {
        // --- TABEL REGISTRASI
        $dataPasien = $this->getDataPasien($params->nomorkartu);
        $dataPasien->waktu          = date('H:i:s');
        dd($dataPasien);

        return DB::connection($this->dbsimrs)->table('registrasi')->insert([
            // 'no_reg' => $noReg,
            // 'no_RM' => $dataPasien->no_rm,
            // 'tgl_reg' => $params->tanggalperiksa,,
            // 'waktu' => $dataPasien->waktu,
            // 'kd_asal_pasien' => $asalPasien,
            // 'status_pengunjung' => $register['status_pengunjung'],
            // 'kd_cara_bayar' => $register['kd_cara_bayar'],
            // 'jenis_pasien' => $jenis_pasien,
            // 'no_reg_pembayar' => $noReg,
            // 'kd_penjamin' => $kd_penjamin,
            // 'no_SJP' => '-',
            // 'user_id' => '000'
        ]);

        // $data->tgl_reg           = $data->tanggalperiksa;
        // $data->waktu             = date('H: i: s');
        // $data->status_pengunjung = 1;
        // $data->kd_cara_bayar     = 8;
        // $data->jenis_pasien      = 0;
        // $data->kd_penjamin       = "Cari By BPJS NO KARTU";
        // $data->no_sjp            = "-";
        // $data->user_id           = "0000000";

        // // ---- TABEL RAWAT JALAN
        // $data->kd_sub_unit = $dataPoli->kd_sub_unit;
        // $data->kd_cara_kunjungan = 1;
        // $data->status_kunjungan  = 1;
        // $data->waktu_anamnesa    = date('H:i:s');
        // $data->kd_dokter  = "KODE DOKTER"; 
        // $data->reg_sms  = 3;

        // $data->no_rujukan =  $params->jenisreferensi;
        // $data->jenis_rujukan =  $params->jenisreferensi;
        // $data->poli_eksekutif =  $params->polieksekutif;
        // $data->nik = $params->nik;
        // $data->no_telp = $params->notelp;
        // dd($data);
    }

    private function getDataPasien($nomorKartu)
    {
        return DB::connection($this->dbsimrs)->table('penjamin_pasien')->select('no_rm','no_kartu')
                ->where('no_kartu', $nomorKartu)->first();
    }

    private function getDataPoli($kodePoli)
    {
        return DB::connection($this->dbsimrs)->table('sub_unit')->select('kd_sub_unit')
                ->where('kd_poli_dpjp', $kodePoli)->first();
    }

    private function getStatusPengunjung($noRm)
    {
        return DB::connection($this->dbsimrs)->table('registrasi')->select('no_rm')
                ->where('no_rm', $noRm)->get();
    }
}
