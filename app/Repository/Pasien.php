<?php

namespace App\Repository;

use DB;

class Pasien
{
    protected $dbsimrs = "sql_simrs";

    public function getPasien($params)
    {
        return DB::connection($this->dbsimrs)->table('pasien')
            ->select('no_rm','nama_pasien','alamat','rt','rw', 'jns_kel','tgl_lahir')
            ->where('no_rm', $params['no_rm'])
            ->first();
    }

    // FOR  ANDROID API
    public function dataPasien($params)
    {
        return DB::connection($this->dbsimrs)->table('pasien')
            ->select('no_rm','nama_pasien','alamat','rt','rw', 'jns_kel','tgl_lahir')
            ->where([['no_rm', '=', $params->no_rm], ['tgl_lahir', '=', $params->tanggal_lahir]])
            ->first();
    }

    public function getBiodataPasien($noRm)
    {
        return DB::connection($this->dbsimrs)->table('Pasien as p')
            ->select('p.no_rm','p.nama_pasien','p.tempat_lahir','p.tgl_lahir as tanggal_lahir','p.jns_kel','p.alamat','p.no_telp','pp.no_kartu', 'p.nik')
            ->join('Penjamin_Pasien as pp', function($join) {
                $join->on('p.no_RM', '=', 'pp.no_RM');
            })
            ->where('p.no_RM', '=', $noRm)
            ->first();
    }
}
