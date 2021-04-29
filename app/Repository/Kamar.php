<?php

namespace App\Repository;

use DB;

class Kamar
{
    protected $dbsimrs = "sql_simrs";

    // convert(varchar, getdate(), 120) as tgl_update

    public function getListBedKemkes()
    {
        return DB::connection($this->dbsimrs)->table('Tempat_Tidur as tt')
            ->select('tt.kd_tt_kemkes as id_tt','su.nama_sub_unit as ruang',
                        DB::raw("
                                1 as jumlah_ruang,
                                sum(case when tt.status=1 or tt.status=0 or tt.status=2 then 1 else 0 end) as jumlah,
                                sum(case when tt.status=1 and kmr.kelamin='l' or tt.status=1 and kmr.kelamin='p' or tt.status=1 and kmr.kelamin='c' then 1 else 0 end) as terpakai,
                                sum(case when tt.status=0 and kmr.kelamin='l' or tt.status=0 and kmr.kelamin='p' or tt.status=0 and kmr.kelamin='c' then 1 else 0 end) as prepare,
                                sum(case when tt.status=2 and kmr.kelamin='l' or tt.status=2 and kmr.kelamin='p' or tt.status=2 and kmr.kelamin='c' then 1 else 0 end) as prepare_plan
                        "),'tt.status_covid as covid' )
            ->join('Kamar as kmr', function($join){
                $join->on('tt.kd_kamar','=', 'kmr.kd_kamar')
                    ->join('sub_unit as su', function($join) {
                        $join->on('kmr.kd_sub_unit', '=', 'su.kd_sub_unit');
                    })
                    ->join('kelas as kls', function($join) {
                        $join->on('kmr.kd_kelas','=', 'kls.kd_kelas');
                    });
            })
            ->join('jenis_kamar as jk', 'tt.kd_jenis_kamar','=', 'jk.kd_jenis_kamar')
            ->where('tt.aktif', 1)
            ->whereIn('tt.status', [0,1,2,3])
            ->whereNotIn('tt.kd_jenis_kamar', [14])
            ->whereNotNull('tt.kd_jenis_kamar')
            ->whereNotNull('tt.kd_tt_kemkes')
            ->groupBy('tt.kd_tt_kemkes','su.nama_sub_unit', 'tt.status_covid')
            ->get();
       
    }

    public function getListBedSiranap()
    {
        return DB::connection($this->dbsimrs)->table('Tempat_Tidur as tt')
            ->select('kls.kode_siranap as kode_ruang','jk.kode_tipe_pasien as tipe_pasien', 
                        DB::raw("
                                sum(case when tt.status=1 or tt.status=0 or tt.status=2 then 1 else 0 end) as total_TT,
                                sum(case when tt.status=1 and kmr.kelamin='l' or tt.status=1 and kmr.kelamin='c' then 1 else 0 end) as terpakai_male,
                                sum(case when tt.status=1 and kmr.kelamin='p' then 1 else 0 end) as terpakai_female,
                                sum(case when tt.status=0 and kmr.kelamin='l' then 1 else 0 end) as kosong_male,
                                sum(case when tt.status=0 and kmr.kelamin='p' or tt.status=0 and kmr.kelamin='c' then 1 else 0 end) as kosong_female,
                                sum(case when tt.status=2 and kmr.kelamin='p' or tt.status=2 and kmr.kelamin='c' or tt.status=2 and kmr.kelamin='l' or tt.status=2 and kmr.kelamin='c' then 1 else 0 end) as waiting,
                                convert(varchar, getdate(), 120) as tgl_update
                        ") )
            ->join('Kamar as kmr', function($join){
                $join->on('tt.kd_kamar','=', 'kmr.kd_kamar')
                    ->join('sub_unit as su', function($join) {
                        $join->on('kmr.kd_sub_unit', '=', 'su.kd_sub_unit');
                    })
                    ->join('kelas as kls', function($join) {
                        $join->on('kmr.kd_kelas','=', 'kls.kd_kelas');
                    });
            })
            ->join('jenis_kamar as jk', 'tt.kd_jenis_kamar','=', 'jk.kd_jenis_kamar')
            ->where('tt.aktif', 1)
            ->whereIn('tt.status', [0,1,2,3])
            ->whereNotIn('tt.kd_jenis_kamar', [14])
            ->whereNotNull('tt.kd_jenis_kamar')
            ->groupBy('kls.kode_siranap', 'jk.kode_tipe_pasien')
            ->get();
    }

    public function getListBedSiranapXml()
    {
        return DB::connection($this->dbsimrs)->table('Tempat_Tidur as tt')
            ->select('kls.kode_siranap as kode_ruang','jk.kode_tipe_pasien as tipe_pasien', 
                        DB::raw("
                                sum(case when tt.status=1 or tt.status=0 or tt.status=2 then 1 else 0 end) as total_TT,
                                sum(case when tt.status=1 and kmr.kelamin='l' or tt.status=1 and kmr.kelamin='c' then 1 else 0 end) as terpakai_male,
                                sum(case when tt.status=1 and kmr.kelamin='p' then 1 else 0 end) as terpakai_female,
                                sum(case when tt.status=0 and kmr.kelamin='l' then 1 else 0 end) as kosong_male,
                                sum(case when tt.status=0 and kmr.kelamin='p' or tt.status=0 and kmr.kelamin='c' then 1 else 0 end) as kosong_female,
                                sum(case when tt.status=2 and kmr.kelamin='p' or tt.status=2 and kmr.kelamin='c' or tt.status=2 and kmr.kelamin='l' or tt.status=2 and kmr.kelamin='c' then 1 else 0 end) as waiting,
                                convert(varchar, getdate(), 120) as tgl_update
                        ") )
            ->join('Kamar as kmr', function($join){
                $join->on('tt.kd_kamar','=', 'kmr.kd_kamar')
                    ->join('sub_unit as su', function($join) {
                        $join->on('kmr.kd_sub_unit', '=', 'su.kd_sub_unit');
                    })
                    ->join('kelas as kls', function($join) {
                        $join->on('kmr.kd_kelas','=', 'kls.kd_kelas');
                    });
            })
            ->join('jenis_kamar as jk', 'tt.kd_jenis_kamar','=', 'jk.kd_jenis_kamar')
            ->where('tt.aktif', 1)
            ->whereIn('tt.status', [0,1,2,3])
            ->whereNotIn('tt.kd_jenis_kamar', [14])
            ->whereNotNull('tt.kd_jenis_kamar')
            ->groupBy('kls.kode_siranap', 'jk.kode_tipe_pasien')
            ->get();
    }
}