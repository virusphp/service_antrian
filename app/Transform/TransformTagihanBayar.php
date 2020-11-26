<?php

namespace App\Transform;

use App\Helpers\Perubahan;

class TransformTagihanBayar
{
    public function mapperTagihanBayar($bayartagihan,$tgl_reg)
    {    
        $data =[];
        $total = 0; 
        foreach($bayartagihan as $val){
            $total += $val->tunai;    
            if($val->jenis_rawat =='RJ'){
                $jns_rawat= "Rawat Jalan";
            }else if($val->jenis_rawat =='RI'){
                $jns_rawat= "Rawat Inap";
            }else{
                $jns_rawat= "Rawat Gawat Darurat";
            }
            $data['pasien']= [
                'no_rm' => $val->no_rm,                 
                'nama_pembayar' => $val->nama_pembayar, 
                'alamat_pembayar' => $val->alamat_pembayar, 
                'nama_pasien' => $val->nama_pasien, 
                'alamat_pasien' => $val->alamat, 
                'untuk_pembayaran' =>$val->untuk.' ('.$jns_rawat.')',
                'total_bayar' =>$total
            ];            
            
            $output[]= [
                'no_kwitansi' => $val->no_kwitansi,
                'tanggal_kwitansi' => Perubahan::tanggalSekarang($val->tgl_kwitansi),
                'jumlah_bayar' => (Float)$val->tunai
            ];
        }       
        $data['rincian_pembayaran'] = $output;        
        return $data;
        
    }

}