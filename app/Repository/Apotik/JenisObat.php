<?php

namespace App\Repository\Apotik;

use DB;

class JenisObat
{
	protected $dbsimrs = "sql_simrs";

	public function getJenisObat($params)
	{
		return DB::connection($this->dbsimrs)
			->table('jenis_obat')->select('kd_jns_obat','jns_obat')
			->where(function($query) use ($params) {
				if(!is_null($params->term)) {
					$keywords = "%". $params->term . "%";
                   	$query->orWhere('jns_obat', 'like', $keywords);
				}
			})
			->where('stsaktif', 1)
			->orderBy('jns_obat', 'asc')
			->get();
	}
}