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
        $total_tunai_all=0;
        $total_retur_all=0;
        $total_piutang_all=0;
        $total_tagihan_all=0;
        foreach($tagihanPasien as $key=>$value){            
            $tunai_tambah =0;
            $tunai_kurang =0;
            $piutang_tambah =0;
            $piutang_kurang =0;
            $tagihan_tambah =0;
            $tagihan_kurang =0;
            $retur_obat_tunai =0;
            foreach($value as $val){                               
                if($val->posisi=='TAMBAH'){
                    $tunai_tambah +=$val->tunai;
                    $piutang_tambah +=$val->piutang;
                    $tagihan_tambah +=$val->tagihan;
                }else{
                    $tunai_kurang +=$val->tunai;
                    $piutang_kurang +=$val->piutang;
                    $tagihan_kurang +=$val->tagihan;
                    $retur_obat_tunai +=$val->tunai;
                }
                $output2[]= [
                    'no_reg' => $val->no_reg,                    
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
                $jenis_rawat =  Perubahan::jenis_rawat($val->no_reg); 
            }                   
            $output[] = [    
                'no_reg' =>$key,
                'jenis_rawat' => $jenis_rawat,            
                'total_bayar' => $tunai_tambah - $retur_obat_tunai,
                'total_piutang' => $piutang_tambah - $piutang_kurang,
                'total_tagihan' => $tagihan_tambah - $tagihan_kurang + $retur_obat_tunai,
                'retur_obat' => $retur_obat_tunai,
            ];
            $total_tunai_all += $tunai_tambah - $retur_obat_tunai;
            $total_retur_all += $retur_obat_tunai;
            $total_piutang_all += $piutang_tambah - $piutang_kurang;
            $total_tagihan_all += $tagihan_tambah - $tagihan_kurang + $retur_obat_tunai;
        }        
        $output3=[
            'bayar' => $total_tunai_all,
            'piutang' => $total_piutang_all,
            'tagihan' => $total_tagihan_all,
            'retur_obat' => $total_retur_all
        ];
        $data['tagihan_total'] = $output3;  
        $data['tagihan'] = $output;
        $data['tagihan_detail'] = $output2;        
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
        $tagihanPasien = $tagihan->groupBy('no_reg_pembayar');
        $total_tunai_all=0;
        $total_retur_all=0;
        $total_piutang_all=0;
        $total_tagihan_all=0;
        $no=0;
        foreach($tagihanPasien as $key=>$value){
            $tunai_tambah =0;
            $tunai_kurang =0;
            $piutang_tambah =0;
            $piutang_kurang =0;
            $tagihan_tambah =0;
            $tagihan_kurang =0;
            $retur_obat_tunai =0;
            foreach($value as $val){                
                if($val->posisi=='TAMBAH'){
                   $tunai_tambah +=$val->tunai;
                   $piutang_tambah +=$val->piutang;
                   $tagihan_tambah +=$val->tagihan;
                }else{
                    $tunai_kurang +=$val->tunai;
                    $piutang_kurang +=$val->piutang;
                    $tagihan_kurang +=$val->tagihan;
                    $retur_obat_tunai +=$val->tunai;
                }
                $output2[$key][] = [
                    'no_reg' => $val->no_reg,
                    'jenis_rawat' => Perubahan::jenis_rawat($val->no_reg),
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
                $jenis_rawat =  Perubahan::jenis_rawat($val->no_reg); 
            }
            
            $output[$key] = [    
                'no_reg' =>$key,
                'jenis_rawat' => $jenis_rawat,            
                'total_bayar' => $tunai_tambah - $retur_obat_tunai,
                'total_piutang' => $piutang_tambah - $piutang_kurang,
                'total_tagihan' => $tagihan_tambah - $tagihan_kurang + $retur_obat_tunai,
                'retur_obat' => $retur_obat_tunai,
                'int' => $no++
                // 'rincian_tagihan' => $output2
            ];
            $total_tunai_all += $tunai_tambah - $retur_obat_tunai;
            $total_retur_all += $retur_obat_tunai;
            $total_piutang_all += $piutang_tambah - $piutang_kurang;
            $total_tagihan_all += $tagihan_tambah - $tagihan_kurang + $retur_obat_tunai;
        }
        $output3=[
            'bayar' => $total_tunai_all,
            'piutang' => $total_piutang_all,
            'tagihan' => $total_tagihan_all,
            'retur_obat' => $total_retur_all
        ]; 
        $data['tagihan_total'] = $output;
        $data['tagihan_detail'] = $output2;
        return $data;
    }

}