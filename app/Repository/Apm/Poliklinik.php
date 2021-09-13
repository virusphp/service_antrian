<?php

namespace App\Repository\Apm;

use Illuminate\Support\Facades\DB;

class Poliklinik
{
	protected $dbsimrs = "sql_simrs";

	public function getPoliBpjs($kdSubUnit)
	{
		return DB::connection($this->dbsimrs)->table('sub_unit')
				->select('kd_poli_dpjp')
				->where('kd_sub_unit', $kdSubUnit)
				->first();
	}

	public function getPoli($kodePoli)
	{
		return DB::connection($this->dbsimrs)->table('poli_bpjs')->select('kode','nama')->where('kode', '=', $kodePoli)->first();
	}
	
}