<?php

namespace App\Repository;

use DB;

class Registrasi
{
    protected $dbsimrs = "sql_simrs";

    public function dataRegistrasi($noRm)
    {
        return DB::connection($this->dbsimrs)->table('Rawat_Jalan AS RJ')
            ->select('RJ.no_reg','R.tgl_reg','R.no_sjp','P.no_rm','P.no_telp','P.nama_pasien','P.rt','P.rw','P.alamat',
                'KEL.nama_kelurahan','KEC.nama_kecamatan','KAB.nama_kabupaten','PROV.nama_propinsi'
                ,'S.nama_sub_unit','PW.nama_pegawai','pp.no_kartu','pp.kd_penjamin_pasien','RJ.kd_poliklinik', 's.kd_poli_dpjp')
            ->join('Registrasi AS R', function($join) {
                $join->on('RJ.no_reg','=', 'R.no_reg')
                    ->join('Penjamin_Pasien AS pp',function ($join) {
                        $join->on('R.no_RM', '=', 'pp.no_RM');
                    });
            })
            ->join('Sub_Unit AS S', function($join) {
                $join->on('RJ.kd_poliklinik', '=', 'S.kd_sub_unit');
            })
            ->join('Pasien AS P', function($join) {
                $join->on('RJ.no_RM', '=', 'P.no_RM')
                    ->join('Kelurahan as KEL',function($join) {
                        $join->on('P.kd_kelurahan', '=', 'KEL.kd_kelurahan')
                            ->join('Kecamatan as KEC', function($join) {
                                $join->on('KEL.kd_kecamatan','=', 'KEC.kd_kecamatan')
                                    ->join('Kabupaten as KAB', function($join) {
                                        $join->on('KEC.kd_kabupaten', '=', 'KAB.kd_kabupaten')
                                            ->join('Propinsi as PROV', function($join) {
                                                $join->on('KAB.kd_propinsi', '=', 'PROV.kd_propinsi');
                                            });
                                    });
                            });
                    });
            })
            ->leftJoin('Jadwal_Dokter_Poli_RJ as DPR', function($join) {
                $join->on('RJ.kd_poliklinik', '=', 'DPR.kd_sub_unit')
                    ->join('Pegawai AS PW', function($join) {
                        $join->on('DPR.kd_pegawai', '=', 'PW.kd_pegawai');
                    });
            })
           
            ->where('RJ.no_RM', '=', $noRm)
            ->where('R.tgl_reg', '=', date('Y-m-d'))
            ->orderBy('RJ.waktu_anamnesa', 'desc')
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
