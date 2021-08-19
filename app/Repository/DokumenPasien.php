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
                ->where('id_file', 'like', $prefix . '%')
                ->max('id_file');
    }

    public function checkData($params)
    {
        // dd($params['id_file']);
        return DB::connection($this->dbsimrs)
                    ->table('pasien_file')
                    ->where('id_file', $params['id_file'])
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
                $dokumenPasien = DB::connection($this->dbsimrs)->table('pasien_file')
                                ->where('id_file', $params['id_file'])->first();
                return $dokumenPasien;
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
                $dokumenPasien = DB::connection($this->dbsimrs)->table('pasien_file')
                                ->where('id_file', $params['id_file'])->first();
                return $dokumenPasien;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }           
    }
}