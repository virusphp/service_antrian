<?php

namespace App\Transform;

use App\Helpers\Perubahan;
use phpDocumentor\Reflection\Types\Float_;

class TransformTagihan
{
    public function mapperTagihan($pasien, $tagihan, $tgl_reg)
    {
        // dd($tagihan);
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
            $total_tunai = 0;
            $total_piutang = 0;
            $total_tagihan = 0;
            $total_retur_obat = 0;
            $jenis_rawat = '';
            $rincianTagihan = $value->groupBy('kelompok');            
            if($rincianTagihan->has('RETUR Farmasi / Obat / Alkes')){
                foreach($rincianTagihan['RETUR Farmasi / Obat / Alkes'] as $r){
                    $total_retur_obat += $r->tunai;
                }
            }           
            foreach($value as $val){
                $output2[] = [
                    'no_tagihan' => $val->no_tagihan,
                    'tanggal_tagihan' => Perubahan::tanggalSekarang($val->tgl_tagihan),
                    'no_bukti' => $val->no_bukti,
                    'kelompok_tagihan' => $val->Tagihan_A,
                    'kelompok' => $val->kelompok,                   
                    'jumlah'=> (int)$val->jumlah,
                    'nama_tarif' => $val->nama_tarif,
                    'harga' => (Float)$val->harga,
                    'tunai' => (Float)$val->tunai,
                    'piutang' => (Float)$val->piutang,
                    'tagihan' => (Float)$val->tagihan,
                    'kd_dokter' =>$val->kd_dokter,
                    'kd_subunit' =>$val->kd_sub_unit,
                    'akun_rek1' => $val->rek_p,
                    'akun_rek2' => $val->rek_p2
                ];
                $total_tunai += $val->tunai;
                $total_piutang += $val->piutang;
                $total_tagihan += $val->tagihan;
                $jenis_rawat =  Perubahan::jenis_rawat($val->no_reg);
            }
            $output[] =[
                'no_reg' =>$key,
                'jenis_rawat' => $jenis_rawat,
                'total_bayar' => $total_tunai - $total_retur_obat,
                'total_piutang' => $total_piutang,
                'total_tagihan' => $total_tagihan,
                'total_retur_obat' => $total_retur_obat,
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
            $total_tunai = 0;
            $total_piutang = 0;
            $total_tagihan = 0;
            $total_retur_obat = 0;
            $jenis_rawat = '';
            $rincianTagihan = $value->groupBy('kelompok');
            if($rincianTagihan->has('RETUR Farmasi / Obat / Alkes')){
                foreach($rincianTagihan['RETUR Farmasi / Obat / Alkes'] as $r){
                    $total_retur_obat += $r->tunai;
                }
            }            
            foreach($value as $val){
                $output2[] = [
                    'no_tagihan' => $val->no_tagihan,
                    'tanggal_tagihan' => Perubahan::tanggalSekarang($val->tgl_tagihan),
                    'no_bukti' => $val->no_bukti,
                    'kelompok_tagihan' => $val->Tagihan_A,
                    'kelompok' => $val->kelompok,
                    'jumlah'=> (int)$val->jumlah,
                    'nama_tarif' => $val->nama_tarif,
                    'harga' => (Float)$val->harga,
                    'tunai' => (Float)$val->tunai,
                    'piutang' => (Float)$val->piutang,
                    'tagihan' => (Float)$val->tagihan,
                    'kd_dokter' =>str_replace(' ', '',$val->kd_dokter),
                    'kd_subunit' =>$val->kd_sub_unit,
                    'akun_rek1' => $val->rek_p,
                    'akun_rek2' => $val->rek_p2,
                
                ];
                $total_tunai += $val->tunai;
                $total_piutang += $val->piutang;
                $total_tagihan += $val->tagihan;
                $jenis_rawat =  Perubahan::jenis_rawat($val->no_reg);                
            }
            $output[] =[
                'no_reg' =>$key,
                'jenis_rawat' => $jenis_rawat,
                'total_tunai' => $total_tunai - $total_retur_obat,
                'total_piutang' => $total_piutang,
                'total_tagihan' => $total_tagihan,
                'total_retur_obat' => $total_retur_obat,
                'rincian_tagihan' =>$output2,
            ]; 
        }
        $data['tagihan'] = $output;
        return $data;
    }

}