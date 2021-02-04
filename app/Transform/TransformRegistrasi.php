<?php

namespace App\Transform;

class TransformRegistrasi
{
    public function mapDataRegistrasi($tableRegistrasi, $tableAntrian)
    {
        $data = [
                'no_reg'             => $tableRegistrasi->no_reg,
                'tgl_reg'            => $tableRegistrasi->tgl_reg,
                'no_rm'              => $tableRegistrasi->no_rm,
                'no_kartu'           => $tableRegistrasi->no_kartu,
                'nama_pasien'        => $tableRegistrasi->nama_pasien,
                'alamat'             => $tableRegistrasi->alamat,
                'alamat_lengkap'     => $tableRegistrasi->alamat.' RT.'.$tableRegistrasi->rt.' RW.'.$tableRegistrasi->rw.' Kel.'.$tableRegistrasi->nama_kelurahan.' Kec.'.$tableRegistrasi->nama_kecamatan.' Kab.'.$tableRegistrasi->nama_kabupaten.' Provinsi '.$tableRegistrasi->nama_propinsi,
                'no_telp'            => $tableRegistrasi->no_telp,
                'kd_penjamin_pasien' => $tableRegistrasi->kd_penjamin_pasien,
                'kd_poliklinik'      => $tableRegistrasi->kd_poliklinik,
                'kd_poli_dpjp'       => $tableRegistrasi->kd_poli_dpjp,
                'nama_sub_unit'      => $tableRegistrasi->nama_sub_unit,
                'nama_pegawai'       => $tableRegistrasi->nama_pegawai,
                'antrian'            => $tableAntrian[0]->noantrian,
                'no_sjp'             => $tableRegistrasi->no_sjp
        ];

        return $data;
    }

}