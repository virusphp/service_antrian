<?php

namespace App\Repository\Apotik;

use DB;

class UnitBagian
{
	protected $dbsimrs = "sql_simrs";

	public function getUnit($params)
	{
		return DB::connection($this->dbsimrs)
			->table('ap_bagian')
			->select('kdbagian','nmbagian')
			->where(function($query) use ($params) {
				if(!is_null($params->term)) {
					$keywords =  "%". $params->term . "%";
                   	$query->orWhere('nmbagian', 'like', $keywords);
				}
			})
			->orderBy('nmbagian', 'asc')
			->get();

	}
}