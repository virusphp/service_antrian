<?php

namespace App\Repository\Apotik;

use DB;

class Pabrik
{
	protected $dbsimrs = "sql_simrs";

	public function getPabrik($params)
	{
		return DB::connection($this->dbsimrs)
			->table('ap_pabrik')->select('kdpabrik','nmpabrik')
			->where(function($query) use ($params) {
				if(!is_null($params->term)) {
					$keywords = "%". $params->term . "%";
                   	$query->orWhere('nmpabrik', 'like', $keywords);
				}
			})
			->orderBy('nmpabrik', 'asc')
			->get();
	}
}