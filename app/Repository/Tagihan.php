<?php

namespace App\Repository;

use DB;

class Tagihan
{
    protected $dbsimrs = "sql_simrs";

    public function getTagihan($params)
    {
        return DB::connection($this->dbsimrs)->table('view_kwitansi as k')
            ->select('k.no_tagihan','k.Tagihan_A','k.no_bukti','k.no_reg','k.tgl_tagihan','k.nama_tarif','k.kelompok','k.tunai','k.posisi','k.rek_p')
            ->where([
                ['k.no_rm', $params['no_rm']],
                ['k.tgl_tagihan', $params['tanggal_tagihan']]
                ])
            ->get();
    }
}
