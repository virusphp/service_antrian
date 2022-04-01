<<<<<<< HEAD
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
            ->select('no_rm','nik as ktp', 'nama_pasien','alamat','rt','rw', 'jns_kel','tgl_lahir')
            ->where([['no_rm', '=', $params->no_rm], ['tgl_lahir', '=', $params->tgl_lahir]])
            ->first();
    }

    public function dataUser($params)
    {
        return DB::connection($this->dbsimrs)
            ->table('user_pasien_online as u')
            ->select('u.no_rm','u.password', 'u.tgl_lahir')
            ->join('pasien as p', 'u.no_rm','=','p.no_rm')
            ->where('u.no_rm', '=', $params->username)
            ->first();
    }

    public function insertUserLogin($params)
    {
        return DB::connection($this->dbsimrs)->table('user_pasien_online')->insert([
            'no_rm' => $params->no_rm,
            'no_ktp' => $params->no_ktp,
            'tgl_lahir' => $params->tgl_lahir,
            'email' => $params->email,
            'password' => app('hash')->make($params->password)
        ]);
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
=======
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
>>>>>>> af0453c07bd5b1ca28aea1665f1a2fec9adf0e26
