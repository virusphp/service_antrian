<?php

namespace App\Repository\Apotik;

use DB;

class Satuan
{
	protected $dbsimrs = "sql_simrs";

	public function getSatuan($params)
	{
		return DB::connection($this->dbsimrs)
			->table('ap_satuan')->select('idsatuan','nmsatuan')
			->where(function($query) use ($params) {
				if(!is_null($params->term)) {
					$keywords = "%". $params->term . "%";
                   	$query->orWhere('nmsatuan', 'like', $keywords);
				}
			})
			->orderBy('nmsatuan', 'asc')
			->get();
	}
}