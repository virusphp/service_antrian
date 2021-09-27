<?php

namespace App\Repository\Apotik;

use DB;

class BarangFarmasi
{
	protected $dbsimrs = "sql_simrs";

	public function getBarang($params)
	{
		return DB::connection($this->dbsimrs)
			->table('barang_farmasi as b')
			->select('b.idx_barang','b.kd_barang','b.nama_barang','b.kd_jns_obat','b.kd_satuan_besar','b.kd_satuan_kecil','b.isi_satuan_besar',
					'b.harga_satuan_besar','b.harga_satuan_netto','b.harga_satuan','b.stok_min','b.dosis','b.satdosis','b.harga_jual',
					'b.diskon_persen','b.ppn1','b.ppn2'
			)
			->where(function($query) use ($params) {
				if(!is_null($params->term)) {
					$keywords =  "%". $params->term . "%";
                   	$query->orWhere('b.nama_barang', 'like', $keywords);
				}
			})
			->where('b.stsaktif', '1')
			->orderBy('b.nama_barang', 'asc')
			->get();

	}
}