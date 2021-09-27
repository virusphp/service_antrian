<?php

namespace App\Repository\Apotik;

use DB;

class GolonganObat
{
	protected $dbsimrs = "sql_simrs";

	public function getGolonganObat($params)
	{
		return DB::connection($this->dbsimrs)
			->table('golongan_obat')->select('kd_gol_obat','gol_obat')
			->where(function($query) use ($params) {
				if(!is_null($params->term)) {
					$keywords = "%". $params->term . "%";
                   	$query->orWhere('gol_obat', 'like', $keywords);
				}
			})
			->where('stsaktif', 1)
			->orderBy('gol_obat', 'asc')
			->get();
	}
}