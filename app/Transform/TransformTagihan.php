<?php

namespace App\Transform;

use App\Helpers\Perubahan;
use phpDocumentor\Reflection\Types\Float_;

class TransformTagihan
{
    public function mapperTagihan($pasien, $tagihan, $tgl_reg)
    {
        $data = [];       
        $data['pasien'] = [
            'no_rm' => trim($pasien->no_rm), 
            'tanggal_registrasi' => $tgl_reg,
            'nama_pasien' => $pasien->nama_pasien, 
            'alamat_pasien' => $pasien->alamat.', RT '.$pasien->rt.' RW '.$pasien->rw.' Kel. '.$pasien->nama_kelurahan.' Kec.'.$pasien->nama_kecamatan.' Kab.'.$pasien->nama_kabupaten.' Prov.'.$pasien->nama_propinsi, 
            'jenis_kelamin_pasien' => Perubahan::jenisKelamin($pasien->jns_kel), 
            'usia_pasien'  => Perubahan::usia($pasien->tgl_lahir),
            'tanggal_lahir_pasien' => Perubahan::tanggalSekarang($pasien->tgl_lahir),
        ];
        $tagihanPasien = $tagihan->groupBy('no_reg');
        foreach($tagihanPasien as $key=>$value) {
            $total = 0;
            $jenis_rawat = '';
            $kelompok_tagihan = '';
            $kelompok = '';
            foreach($value as $val){
                $output2[] = [
                    'no_tagihan' => $val->no_tagihan,
                    'tanggal_tagihan' => Perubahan::tanggalSekarang($val->tgl_tagihan),
                    'no_bukti' => $val->no_bukti,
                    'kelompok_tagihan' => $val->Tagihan_A,
                    'kelompok' => $val->kelompok,
                    // 'no_reg' => $val->no_reg,
                    // 'jenis_rawat' => Perubahan::jenis_rawat($val->no_reg),
                    'jumlah'=> (int)$val->jumlah,
                    'nama_tarif' => $val->nama_tarif,
                    'biaya' => (Float)$val->tunai,
                    'kd_dokter' =>$val->kd_dokter,
                    'kd_subunit' =>$val->kd_sub_unit,
                    'akun_rek1' => $val->rek_p,
                    'akun_rek2' => $val->rek_p2
                ];
                $total += $val->tunai;
                $jenis_rawat =  Perubahan::jenis_rawat($val->no_reg);
                $kelompok_tagihan = $val->Tagihan_A;
                $kelompok = $val->kelompok;
            }
            $output[] =[
                'no_reg' =>$key,
                'jenis_rawat' => $jenis_rawat,
                'total_tagihan' => $total,
                'rincian_tagihan' =>$output2,
            ]; 
        }
        $data['tagihan'] = $output;
        return $data;
    }

    public function mapperTagihanBayar($pasien, $tagihan, $databayar)
    {
        $data = [];       
        $data['pasien'] = [
            'no_rm' => trim($pasien->no_rm), 
            'tanggal_registrasi' => $databayar['tanggal_registrasi'],
            'nama_pasien' => $pasien->nama_pasien, 
            'alamat_pasien' => $pasien->alamat.', RT '.$pasien->rt.' RW '.$pasien->rw.' Kel. '.$pasien->nama_kelurahan.' Kec.'.$pasien->nama_kecamatan.' Kab.'.$pasien->nama_kabupaten.' Prov.'.$pasien->nama_propinsi, 
            'nama_pembayar' => $databayar['nama_pembayar'], 
            'alamat_pembayar' => $databayar['alamat_pembayar']
        ];
        $tagihanPasien = $tagihan->groupBy('no_reg');
        foreach($tagihanPasien as $key=>$value) {
            $total = 0;
            $jenis_rawat = '';
            $kelompok_tagihan = '';
            $kelompok = '';
            foreach($value as $val){
                $output2[] = [
                    'no_tagihan' => $val->no_tagihan,
                    'tanggal_tagihan' => Perubahan::tanggalSekarang($val->tgl_tagihan),
                    'no_bukti' => $val->no_bukti,
                    'kelompok_tagihan' => $val->Tagihan_A,
                    'kelompok' => $val->kelompok,
                    'jumlah'=> (int)$val->jumlah,
                    'nama_tarif' => $val->nama_tarif,
                    'biaya' => (Float)$val->tunai,
                    'kd_dokter' =>str_replace(' ', '',$val->kd_dokter),
                    'kd_subunit' =>$val->kd_sub_unit,
                    'akun_rek1' => $val->rek_p,
                    'akun_rek2' => $val->rek_p2,
                
                ];
                $total += $val->tunai;
                $jenis_rawat =  Perubahan::jenis_rawat($val->no_reg);
                $kelompok_tagihan = $val->Tagihan_A;
                $kelompok = $val->kelompok;
            }
            $output[] =[
                'no_reg' =>$key,
                'jenis_rawat' => $jenis_rawat,
                'total_tagihan' => $total,
                'rincian_tagihan' =>$output2,
            ]; 
        }
        $data['tagihan'] = $output;
        return $data;
    }

}