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
                'tanggal_lahir'  => $biodataSimrs->tanggal_lahir,
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

}