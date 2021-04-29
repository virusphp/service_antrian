<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class Poliklinik 
{
    protected $dbsimrs = "sql_simrs";

    public function getListPoli()
    {
        return DB::connection($this->dbsimrs)->table('tarif_karcis_rj as trj')
            ->select('trj.kd_sub_unit','su.nama_sub_unit', 'trj.kd_tarif','trj.nama_tarif')
            ->join('sub_unit as su', function($join) {
                $join->on('trj.kd_sub_unit','=','su.kd_sub_unit')
                    ->where([
                        ['su.enabled', '=', 1],
                        ['su.kd_unit', '=', 1],
                    ]);
            })
            ->orderBy('su.nama_sub_unit', 'asc')
            ->get();
    }

    public function getTarifPoli($kodePoli)
    {
        return DB::connection($this->dbsimrs)->table('tarif_karcis_rj as trj')
            ->select('trj.kd_sub_unit','su.nama_sub_unit', 'trj.harga','trj.rek_p','trj.kd_tarif','trj.nama_tarif')
            ->join('sub_unit as su', function($join) {
                $join->on('trj.kd_sub_unit','=','su.kd_sub_unit')
                    ->where([
                        ['su.enabled', '=', 1],
                        ['su.kd_unit', '=', 1],
                    ]);
            })
            ->where('trj.kd_sub_unit', '=', $kodePoli)
            ->first();
    }
}