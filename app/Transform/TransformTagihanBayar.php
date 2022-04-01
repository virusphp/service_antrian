<?php

namespace App\Transform;

use App\Helpers\Perubahan;

class TransformTagihanBayar
{
    public function mapperTagihanBayarInsert($bayartagihan)
    {   
        $data =[];
        $total_bayar=0;
        $bayartagihanCollect = collect($bayartagihan);
        $tagihanBykwitansi = $bayartagihanCollect->groupBy('no_kwitansi');
        foreach($tagihanBykwitansi as $key=>$value){
            $bayar =0;
            foreach($value as $val){
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
                ]; 
               
                $output[]= [
                    'no_kwitansi' => $val['no_kwitansi'],
                    'tanggal_kwitansi' => Perubahan::tanggalSekarang($val['tgl_kwitansi']),
                    'no_bukti' => $val['no_bukti'],
                    'nama_tarif' => $val['nama_tarif'],
                    'kelompok' => $val['kelompok'],
                    'harga' => (String)$val['harga'],
                    'tunai' => (String)$val['tunai'],                
                    'tagihan' => (String)$val['tagihan'],
                ];
                $bayar = $val['total_bayar'];
            }
            $total_bayar +=$bayar;
            $no_kw[]=$key;
            
        } 
        $data['pembayaran']['total_bayar'] = (String)Perubahan::round_up($total_bayar,-2);
        $data['pembayaran']['no_kwitansi'] = $no_kw;
        $data['rincian_pembayaran']= $output;
        return $data;
        
    }

    public function mapperTagihanBayarLunas($bayartagihan)
    { 
        $data =[];
        $total_bayar = 0; 
        $tagihanBykwitansi = $bayartagihan->groupBy('no_kwitansi');
        foreach($tagihanBykwitansi as $key=>$value){ 
            $bayar =0;
            foreach($value as $val){
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
                ];    
                $output[]= [
                    'no_kwitansi' => $val->no_kwitansi,
                    'tanggal_kwitansi' => Perubahan::tanggalSekarang($val->tgl_kwitansi),
                    'no_bukti' => $val->no_bukti,
                    'nama_tarif' => $val->nama_tarif,
                    'kelompok' => $val->kelompok,
                    'harga' => (float)$val->harga,
                    'tunai' => (float)$val->tunai,
                    'tagihan' => (float)$val->tagihan,
                ];
                $bayar = $val->grandtotal_tunai;
            }  
            $total_bayar +=$bayar;
        }    
        $data['pembayaran']['total_bayar'] = (float)$total_bayar;
        $data['rincian_pembayaran'] = $output; 
        return $data;
        
    }

}