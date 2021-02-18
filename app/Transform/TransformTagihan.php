<?php

namespace App\Transform;

use App\Helpers\Perubahan;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Float_;

class TransformTagihan
{

    public function mapperTagihan($pasien, $tagihan)
    {
        $data = [];
        $data['pasien'] = [
            'no_rm' => trim($pasien->no_rm), 
            'nama_pasien' => $pasien->nama_pasien, 
            'alamat_pasien' => $pasien->alamat.', RT '.$pasien->rt.' RW '.$pasien->rw.' Kel. '.$pasien->nama_kelurahan.' Kec.'.$pasien->nama_kecamatan.' Kab.'.$pasien->nama_kabupaten.' Prov.'.$pasien->nama_propinsi, 
            'jenis_kelamin_pasien' => Perubahan::jenisKelamin($pasien->jns_kel), 
            'usia_pasien'  => (String)Perubahan::usia($pasien->tgl_lahir),
            'tanggal_lahir_pasien' => Perubahan::tanggalSekarang($pasien->tgl_lahir),
        ];
        $cekKelompok = count($tagihan->groupBy('kelompok'));
        if($cekKelompok > 7){
            return $this->groupByNoreg($data,$tagihan);             
        }
        else{
            return $this->groupByKelompok($data,$tagihan);
        }
    }

    public function groupByNoreg($data,$tagihan)
    {
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
                    'jumlah'=> $val->jumlah,
                    'nama_tarif' => $val->nama_tarif,
                    'harga' => $val->harga,
                    'tunai' => $val->tunai,
                    'piutang' => $val->piutang,
                    'tagihan' => $val->tagihan,
                    'kd_dokter' =>$val->kd_dokter,
                    'kd_subunit' =>$val->kd_sub_unit,
                    'akun_rek1' => $val->rek_p,
                    'akun_rek2' => $val->rek_p2
                ];      
                $jenis_rawat =  Perubahan::jenis_rawat($val->no_reg); 
                $tgl_reg = Perubahan::tanggalIndo($val->tgl_reg);
            }
            $besar_tagihan = $tunai_tambah - $retur_obat_tunai;         
            $output[] = [    
                'no_reg' =>$key,
                'tanggal_registrasi' => $tgl_reg,
                'keterangan' => $jenis_rawat,            
                'besar_tagihan' => (String)Perubahan::round_up($besar_tagihan,-2),
                // 'total_piutang' => (String)($piutang_tambah - $piutang_kurang),
                // 'total_tagihan' => (String)($tagihan_tambah - $tagihan_kurang + $retur_obat_tunai),
                // 'retur_obat' => (String)($retur_obat_tunai),
            ];
            $total_tunai_all += $tunai_tambah - $retur_obat_tunai;
            $total_retur_all += $retur_obat_tunai;
            $total_piutang_all += $piutang_tambah - $piutang_kurang;
            $total_tagihan_all += $tagihan_tambah - $tagihan_kurang + $retur_obat_tunai;
        }        
        $output3=[
            'tagihan_bayar' => (String)Perubahan::round_up($total_tunai_all,-2),
            'keterangan_bayar' => 'Pembayaran Tagihan Rumah Sakit' 
            // 'piutang' => (String)$total_piutang_all,
            // 'tagihan' => (String)$total_tagihan_all,
            // 'retur_obat' => (String)$total_retur_all
        ];
        $data['tagihan_total'] = $output3;  
        $data['tagihan'] = $output;
        // $data['tagihan_detail'] = $output2;        
        return $data;
    }

    public function groupByKelompok($data,$tagihan)
    {
        $tagihanPasien = $tagihan->groupBy('kelompok');
        $total_tunai_all=0;
        $total_retur_all=0;
        $total_piutang_all=0;
        $total_tagihan_all=0;
        foreach($tagihanPasien as $key=>$value){ 
            // dd($value);  
            $tunai_tambah =0;
            $tunai_kurang =0;
            $piutang_tambah =0;
            $piutang_kurang =0;
            $tagihan_tambah =0;
            $tagihan_kurang =0;
            $retur_obat_tunai =0;
            $no_reg = '';
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
                    'jumlah'=> $val->jumlah,
                    'nama_tarif' => $val->nama_tarif,
                    'harga' => $val->harga,
                    'tunai' => $val->tunai,
                    'piutang' => $val->piutang,
                    'tagihan' => $val->tagihan,
                    'kd_dokter' =>$val->kd_dokter,
                    'kd_subunit' =>$val->kd_sub_unit,
                    'akun_rek1' => $val->rek_p,
                    'akun_rek2' => $val->rek_p2
                ];      
                $jenis_rawat =  Perubahan::jenis_rawat($val->no_reg); 
                $tgl_reg = Perubahan::tanggalIndo($val->tgl_reg);
                $no_reg= $val->no_reg;
            }
            $besar_tagihan = $tunai_tambah - $retur_obat_tunai;         
            $output[] = [    
                'no_reg' =>$no_reg,
                'tanggal_registrasi' => $tgl_reg,
                'keterangan' => 'Biaya '.$key,            
                'besar_tagihan' => (String)Perubahan::round_up($besar_tagihan,-2),
                // 'total_piutang' => (String)($piutang_tambah - $piutang_kurang),
                // 'total_tagihan' => (String)($tagihan_tambah - $tagihan_kurang + $retur_obat_tunai),
                // 'retur_obat' => (String)($retur_obat_tunai),
            ];
            $total_tunai_all += $tunai_tambah - $retur_obat_tunai;
            $total_retur_all += $retur_obat_tunai;
            $total_piutang_all += $piutang_tambah - $piutang_kurang;
            $total_tagihan_all += $tagihan_tambah - $tagihan_kurang + $retur_obat_tunai;
        }        
        $output3=[
            'tagihan_bayar' => (String)Perubahan::round_up($total_tunai_all,-2),
            'keterangan_bayar' => 'Pembayaran Tagihan Rumah Sakit' 
            // 'piutang' => (String)$total_piutang_all,
            // 'tagihan' => (String)$total_tagihan_all,
            // 'retur_obat' => (String)$total_retur_all
        ];
        $data['tagihan_total'] = $output3;  
        $data['tagihan'] = $output;
        // $data['tagihan_detail'] = $output2;        
        return $data;
    }

    public function mapperTagihanBayar($pasien, $tagihan, $databayar)
    {
        $data = [];       
        $data['pasien'] = [
            'no_rm' => trim($pasien->no_rm),             
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
                $tgl_reg = Perubahan::tanggalIndo($val->tgl_reg);
            }
            $total_bayar = $tunai_tambah - $retur_obat_tunai;
            $output[$key] = [    
                'no_reg' =>$key,
                'tanggal_registrasi' => $tgl_reg,
                'jenis_rawat' => $jenis_rawat,            
                'total_bayar' => $total_bayar,
                'total_bayar_bulat' => Perubahan::round_up($total_bayar,-2),
                'total_tunai' => $tunai_tambah,
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