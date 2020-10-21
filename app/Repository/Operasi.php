<?php

namespace App\Repository;

use DB;
use Carbon\Carbon;
use Exception;
use App\Helpers\BPJSHelper;
use Illuminate\Support\Facades\Hash;

class Operasi
{
    public function postOperasi($params)
    {
        try {
            $listOperasi = DB::table('dbsimrm.dbo.jadwal_operasi as jo')->select(
                    'jo.no_jadwal_ok','jo.tgl_tindakan','jto.nama_jenis_tindakan_operasi','su.kd_poli_dpjp','pb.nama','jo.status_proses'
                )
                ->join('dbsimrs.dbo.pegawai as p', 'jo.kd_dokter','=', 'p.kd_pegawai')
                ->join('dbsimrm.dbo.jenis_tindakan_operasi as jto', 'jo.kd_jenis_tindakan_operasi', '=', 'jto.kd_jenis_tindakan_operasi')
                ->leftJoin('dbsimrs.dbo.sub_unit as su', 'p.kd_sub_unit', '=', 'su.kd_sub_unit')
                ->join('dbsimrs.dbo.poli_bpjs as pb', 'su.kd_poli_dpjp','=', 'pb.kode')
                ->join('dbsimrs.dbo.penjamin_pasien as pp', 'jo.no_rm','=','pp.no_rm')
                ->where([
                    ['pp.no_kartu', $params->nopeserta],
                    ['jo.status_proses', 0],
                ])->get();

            return $listOperasi;
            
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function postJadwal($params)
    {
        try {
            $listJadwal = DB::table('dbsimrm.dbo.jadwal_operasi as jo')->select(
                    'jo.no_jadwal_ok','jo.tgl_tindakan','jto.nama_jenis_tindakan_operasi','su.kd_poli_dpjp',
                    'pb.nama','jo.status_proses','pp.no_kartu'
                )
                ->join('dbsimrs.dbo.pegawai as p', 'jo.kd_dokter','=', 'p.kd_pegawai')
                ->join('dbsimrm.dbo.jenis_tindakan_operasi as jto', 'jo.kd_jenis_tindakan_operasi', '=', 'jto.kd_jenis_tindakan_operasi')
                ->leftJoin('dbsimrs.dbo.sub_unit as su', 'p.kd_sub_unit', '=', 'su.kd_sub_unit')
                ->join('dbsimrs.dbo.poli_bpjs as pb', 'su.kd_poli_dpjp','=', 'pb.kode')
                ->join('dbsimrs.dbo.penjamin_pasien as pp', 'jo.no_rm','=','pp.no_rm')
                ->whereBetween('jo.tgl_tindakan', [$params->tanggalawal, $params->tanggalakhir])
                ->get();

            return $listJadwal;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
  
}