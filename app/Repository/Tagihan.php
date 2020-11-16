<?php

namespace App\Repository;

use DB;

class Tagihan
{
    protected $dbsimrs = "sql_simrs";

    public function getTagihanRJ($params)
    {
        return DB::connection($this->dbsimrs)->table('view_kwitansi as k')
            ->select('k.no_tagihan','k.Tagihan_A','k.no_bukti','k.no_reg','k.tgl_tagihan','k.nama_tarif','k.kelompok','k.tunai','k.posisi','k.rek_p')
            ->where([
                ['k.no_rm', $params['no_rm']],
                ['k.tgl_tagihan', $params['tanggal_tagihan']]
                ])
            ->where('no_reg','like','01%')
            ->get();
    }

    public function getTagihanRI($params)
    {
        return DB::connection($this->dbsimrs)->table('view_kwitansi as k')
            ->select('k.no_tagihan','k.Tagihan_A','k.no_bukti','k.no_reg','k.tgl_tagihan','k.nama_tarif','k.kelompok','k.tunai','k.posisi','k.rek_p')
            ->where([
                ['k.no_rm', $params['no_rm']],
                ['k.tgl_tagihan', $params['tanggal_tagihan']]
                ])
            ->where('no_reg','like','02%')
            ->get();
    }

    public function getTagihanRD($params)
    {
        return DB::connection($this->dbsimrs)->table('view_kwitansi as k')
            ->select('k.no_tagihan','k.Tagihan_A','k.no_bukti','k.no_reg','k.tgl_tagihan','k.nama_tarif','k.kelompok','k.tunai','k.posisi','k.rek_p')
            ->where([
                ['k.no_rm', $params['no_rm']],
                ['k.tgl_tagihan', $params['tanggal_tagihan']]
                ])
            ->where('no_reg','like','03%')
            ->get();
    }

    public function bayarTagihan($params)
    {
        
        $nokwitansi = $this->no_kwitansi($params);
        $dataKwitansiHedaer = array(
            'no_kwitansi' => $nokwitansi,
            'nama_pembayar' =>'',
            'alamat_pembayar' =>'',
            'untuk' =>'',
            'tgl_kwitansi' =>'',
            'jenis_rawat' =>'',
            'no_rm' =>'',
            'no_reg' =>'',
            'nama_pasien' =>'',
            'alamat' =>'',
            'jenis_pasien' =>'',
            'kd_penjamin' =>'',
            'nama_penjamin' =>'',
            'no_surat' =>'',
            'uang_muka' =>'',
            'tunai' =>'',
            'piutang' =>'',
            'tagihan' =>'',
            'retur_obat_tunai' =>'',
            'retur_obat_piutang' =>'',
            'potongan' =>'',
            'grandtotal_tunai' =>'',
            'grandtotal_piutang' =>'',
            'grandtotal_Tunai_Bulet' =>'',
            'Iur_Bayar' =>'',
            'Iur_Bayar_Bulet' =>'',
            'kd_kasir' =>'',
            'status_bayar' =>'',
            'user_id' =>'',
            'tgl_insert' =>'',
            'user_edit' =>'',
            'Potongan_Persen_Obat' => '',
			'Potongan_Rupiah_Obat' => '',
			'Potongan_Persen_Tindakan' => '',
			'Potongan_Rupiah_Tindakan' => '',
			'Paket_Hak_Kelas' => '',
			'Paket_Kelas_Rawat' => '',
			'Piutang_Pasien' => '',
			'Piutang_Penjamin_Lainnya' => '',
            'Total_Plafonase' => '',
            'metode_pembayaran' => 2
        );
    }

    public function no_kwitansi($params)
    {
        $jenis =  "K".$params['jenis_rawat'].date('dmy');       
        $query = DB::connection($this->dbsimrs)->table('kwitansi_header')
                ->where('no_kwitansi','like',$jenis.'%')
                ->max('no_kwitansi');
        $noUrut = (int) substr($query, 9, 4);
        $noUrut++;
        $newID = $jenis . sprintf("%04s", $noUrut).'00';
        return $newID; 
    }
}
