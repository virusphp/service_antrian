<?php

namespace App\Transform;

use App\Helpers\Perubahan;

class TransformTagihanBayar
{
    public function mapperTagihanBayarInsert($bayartagihan,$tgl_reg)
    {    
        // dd($bayartagihan);
        $data =[];
        $total_tunai = 0; 
        foreach($bayartagihan as $val){
            // $total_tunai += $val['tunai'];
            if($val['jenis_rawat'] =='RJ'){
                $jns_rawat= "Rawat Jalan";
            }else if($val['jenis_rawat'] =='RI'){
                $jns_rawat= "Rawat Inap";
            }else{
                $jns_rawat= "Rawat Gawat Darurat";
            }
            $data['pembayaran']= [
                'no_rm' => $val['no_rm'],                 
                'nama_pembayar' => $val['nama_pembayar'], 
                'alamat_pembayar' => $val['alamat_pembayar'], 
                'nama_pasien' => $val['nama_pasien'], 
                'alamat_pasien' => $val['alamat'], 
                'untuk_pembayaran' =>$val['untuk'].' ('.$jns_rawat.')',
                'no_kwitansi' => $val['no_kwitansi'],
                'tanggal_kwitansi' => Perubahan::tanggalSekarang($val['tgl_kwitansi']),
                'total_bayar' =>$val['total_bayar']
            ];       
            
            
            $output[]= [
                'no_bukti' => $val['no_bukti'],
                'nama_tarif' => $val['nama_tarif'],
                'kelompok' => $val['kelompok'],
                'harga' => $val['harga'],
                'tunai' => $val['tunai'],
                'tagihan' => $val['tagihan'],
            ];
            
        }    
        // dd($data);   
        $data['rincian_pembayaran'] = $output;        
        return $data;
        
    }

    public function mapperTagihanBayarLunas($bayartagihan,$tgl_reg)
    {    
        // dd($bayartagihan);
        $data =[];
        $total_tunai = 0; 
        foreach($bayartagihan as $val){
            // dd($val->no_rm);
            // $total_tunai += $val->tunai;
            if($val->jenis_rawat =='RJ'){
                $jns_rawat= "Rawat Jalan";
            }else if($val->jenis_rawat =='RI'){
                $jns_rawat= "Rawat Inap";
            }else{
                $jns_rawat= "Rawat Gawat Darurat";
            }
            $data['pembayaran']= [
                'no_rm' => $val->no_rm,                 
                'nama_pembayar' => $val->nama_pembayar, 
                'alamat_pembayar' => $val->alamat_pembayar, 
                'nama_pasien' => $val->nama_pasien, 
                'alamat_pasien' => $val->alamat, 
                'untuk_pembayaran' =>$val->untuk.' ('.$jns_rawat.')',
                'no_kwitansi' => $val->no_kwitansi,
                'tanggal_kwitansi' => Perubahan::tanggalSekarang($val->tgl_kwitansi),
                'total_bayar' =>(float)$val->grandtotal_tunai
            ];       
            
            
            $output[]= [
                'no_bukti' => $val->no_bukti,
                'nama_tarif' => $val->nama_tarif,
                'kelompok' => $val->kelompok,
                'harga' => (float)$val->harga,
                'tunai' => (float)$val->tunai,
                'tagihan' => (float)$val->tagihan,
            ];
            
        }    
        // dd($data);   
        $data['rincian_pembayaran'] = $output;        
        return $data;
        
    }

}