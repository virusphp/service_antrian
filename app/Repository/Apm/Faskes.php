<?php

namespace App\Repository\Apm;

use Illuminate\Support\Facades\DB;

class Faskes
{
	protected $dbsimrs = "sql_simrs";

	public function getFaskes($kodeFaskes)
	{
		return DB::connection($this->dbsimrs)->table('faskes_bpjs')->select('kode','nama','jenis_faskes')->where('kode', '=', $kodeFaskes)->first();
	}
}