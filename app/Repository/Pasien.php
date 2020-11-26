<?php

namespace App\Repository;

use DB;

class Pasien
{
    protected $dbsimrs = "sql_simrs";

    public function getPasien($params)
    {
        return DB::connection($this->dbsimrs)->table('pasien as p')
            ->select('p.no_rm','p.nama_pasien','p.alamat','p.rt','p.rw', 'p.jns_kel','p.tgl_lahir','kel.nama_kelurahan','kec.nama_kecamatan','kab.nama_kabupaten','prov.nama_propinsi')
            ->join('kelurahan as kel','p.kd_kelurahan','=','kel.kd_kelurahan','left')
            ->join('kecamatan as kec','kel.kd_kecamatan','=','kec.kd_kecamatan')
            ->join('kabupaten as kab','kec.kd_kabupaten','=','kab.kd_kabupaten')
            ->join('propinsi as prov','kab.kd_propinsi','=','prov.kd_propinsi')
            ->where('p.no_rm', $params['no_rm'])
            ->first();
    }
}
