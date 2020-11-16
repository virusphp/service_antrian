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
}
