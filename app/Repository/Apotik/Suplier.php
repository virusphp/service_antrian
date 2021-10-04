<?php

namespace App\Repository\Apotik;

use DB;

class Suplier
{
	protected $dbsimrs = "sql_simrs";

	public function getSuplier($params)
	{
		return DB::connection($this->dbsimrs)
			->table('ap_suplier')->select('kdsuplier','nmsuplier', 'alamat','telpon' 
			)
			->where(function($query) use ($params) {
				if(!is_null($params->term)) {
					$keywords = "%". $params->term . "%";
                   	$query->orWhere('nmsuplier', 'like', $keywords);
				}
			})
			->orderBy('nmsuplier', 'asc')
			->get();
	}
}