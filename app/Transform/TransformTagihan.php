<?php

namespace App\Transform;

use App\Helpers\Perubahan;

class TransformTagihan
{
    public function mapperTagihan($pasien, $tagihan)
    {
        $t = [];
        $total = 0;
        foreach($tagihan as $val) {
            $t['rincian_tagihan'][] = [
                'no_tagihan'       => $val->no_tagihan,
                'kelompok_tagihan' => $val->Tagihan_A,
                'no_bukti'         => $val->no_bukti,
                'no_reg'           => $val->no_reg,
                'jenis_rawat'      => Perubahan::jenis_rawat($val->no_reg),
                'tanggal_tagihan'  => Perubahan::tanggalSekarang($val->tgl_tagihan),
                'nama_tarif'       => $val->nama_tarif,
                'biaya'            => (int)$val->tunai,
            ];
            $total += $val->tunai;
        }

        $p['pasien'] = [
           'no_rm'                => trim($pasien->no_rm), 
           'nama_pasien'          => $pasien->nama_pasien, 
           'alamat_pasien'        => $pasien->alamat.', RT '.$pasien->rt.' RW '.$pasien->rw, 
           'jenis_kelamin_pasien' => Perubahan::jenisKelamin($pasien->jns_kel), 
           'usia_pasien'          => Perubahan::usia($pasien->tgl_lahir),
           'tanggal_lahir_pasien' => Perubahan::tanggalSekarang($pasien->tgl_lahir),
           'total_tagihan'        => $total,
        ];

        $data = [
            $p,
            $t
        ];

        return $data;
    }

}