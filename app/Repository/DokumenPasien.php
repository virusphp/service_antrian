<?php

namespace App\Repository;

use DB;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class DokumenPasien
{
    protected $dbsimrs = "sql_simrs";

    public function getMaxNumber($prefix)
    {
        return DB::connection($this->dbsimrs)
                ->table('pasien_file')
                ->whereDate('tgl_created', Carbon::today())
                ->where('id_file', 'like', $prefix . '%')
                ->max('id_file');
    }

    public function checkData($idFile)
    {
        return DB::connection($this->dbsimrs)
                    ->table('pasien_file as pf')
                    ->select('pf.id_file','pf.no_rm','pf.no_reg','pf.kd_jenis_file','pf.file_pasien','pf.tgl_created',
                            'pf.user_created','p.nama_pegawai')
                    ->join('pegawai as p', 'pf.user_created','p.kd_pegawai')
                    ->where('id_file', $idFile)
                    ->first();
    }

    public function simpan($params)
    {
        try {
            $dokumenPasien = DB::connection($this->dbsimrs)->table('pasien_file')
                            ->insert([
                                'id_file' => $params['id_file'],
                                'no_rm' => $params['no_rm'],
                                'no_reg' => $params['no_reg'],
                                'kd_jenis_file' => $params['kode_jenis_file'],
                                'file_pasien' => $params['file_pasien'],
                                'tgl_created' => Carbon::now(),
                                'user_created' => $params['kode_pegawai']
                            ]);
            if ($dokumenPasien) {
                $dokumen = DB::connection($this->dbsimrs) ->table('pasien_file as pf')
                                ->select('pf.id_file','pf.no_rm','pf.no_reg','pf.kd_jenis_file','pf.file_pasien','pf.tgl_created',
                                        'pf.user_created','p.nama_pegawai')
                                ->join('pegawai as p', 'pf.user_created','p.kd_pegawai')
                                ->where('id_file', $params['id_file'])
                                ->first();
                return $dokumen;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }           
    }

    public function update($params)
    {
        try {
            $dokumenPasien = DB::connection($this->dbsimrs)->table('pasien_file')
                            ->where('id_file', $params['id_file'])
                            ->update([
                                'id_file' => $params['id_file'],
                                'no_rm' => $params['no_rm'],
                                'no_reg' => $params['no_reg'],
                                'kd_jenis_file' => $params['kode_jenis_file'],
                                'file_pasien' => $params['file_pasien'],
                                'tgl_created' => Carbon::now(),
                                'user_created' => $params['kode_pegawai']

                            ]);
            if ($dokumenPasien) {
                $dokumenPasien = DB::connection($this->dbsimrs) ->table('pasien_file as pf')
                    ->select('pf.id_file','pf.no_rm','pf.no_reg','pf.kd_jenis_file','pf.file_pasien','pf.tgl_created',
                            'pf.user_created','p.nama_pegawai')
                    ->join('pegawai as p', 'pf.user_created','p.kd_pegawai')
                    ->where('id_file', $params['id_file'])
                    ->first();
                return $dokumenPasien;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }           
    }

    public function deleteDokumen($idFile)
    {
        return DB::connection($this->dbsimrs)->table('pasien_file')
                    ->where('id_file', $idFile)
                    ->delete();
    }
}