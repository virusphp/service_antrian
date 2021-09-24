<?php

namespace App\Repository\Apotik;

use DB;

class KelompokObat
{
	protected $dbsimrs = "sql_simrs";

	public function getKelompokObat($params)
	{
		return DB::connection($this->dbsimrs)
			->table('kelompok_obat')->select('kd_kel_obat','kel_obat')
			->where(function($query) use ($params) {
				if(!is_null($params->term)) {
					$keywords = "%". $params->term . "%";
                   	$query->orWhere('kel_obat', 'like', $keywords);
				}
			})
			->where('stsaktif', 1)
			->orderBy('kel_obat', 'asc')
			->get();
	}
}