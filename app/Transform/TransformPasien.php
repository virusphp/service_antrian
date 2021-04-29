<?php

namespace App\Transform;

use App\Helpers\Perubahan;

class TransformPasien
{
    public function mapperBiodata($biodataSimrs, $biodataBpjs)
    {
        // dd($biodataSimrs->jns_kel, $biodataBpjs);
        $data["biodata"] = [
                'no_rm'          => $biodataSimrs->no_rm,
                'nama'           => $biodataSimrs->nama_pasien,
                'tempat_lahir'   => $biodataSimrs->tempat_lahir,
                'tanggal_lahir'  => Perubahan::tanggalSekarang($biodataSimrs->tanggal_lahir),
                'jenis_kelamin'  => Perubahan::jenisKelamin($biodataSimrs->jns_kel),
                'alamat'         => $biodataSimrs->alamat,
                'kartu_identias' => [
                    'jenis'      => "KTP",
                    'nomor'      => $biodataBpjs->nik,
                    'alamat'     => $biodataSimrs->alamat
                ],
                'kartu_asuransi' => [
                    'JENIS'      => $biodataBpjs->jenis_peserta,
                    'NOMOR'      => $biodataSimrs->no_kartu,
                    'STATUS'     => $biodataBpjs->status
                ],
                'kontak'         => [
                    "jenis"      => 'HP',
                    'nomor'      => $biodataSimrs->no_telp
                ] 
        ];

        return $data;
    }

    public function mapperRegisterUser($table)
    {
        $data['user_login'] = [
            'no_rm'     => $table->no_rm,
            'no_ktp'    => $table->no_ktp,
            'email'     => $table->email,
            'tgl_lahir' => $table->tgl_lahir,
        ];

        return $data;
    }

    public function mapperUserLogin($table)
    {
        $data['user_profil'] = [
            'no_rm'         => $table->no_rm,
            'no_ktp'        => $table->nik,
            'nama_pasien'   => $table->nama_pasien,
            'tempat_lahir'  => $table->tempat_lahir,
            'tanggal_lahir' => Perubahan::tanggalSekarang($table->tanggal_lahir),
            'jenis_kelamin' => strtoupper(Perubahan::jenisKelamin($table->jns_kel)),
            'alamat'        => $table->alamat,
            'no_kartu'      => $table->no_kartu,
            'no_telp'       => $table->no_telp,
        ];

        return $data;
    }

}