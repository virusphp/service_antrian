<?php

namespace App\Repository\Apm;

use Illuminate\Support\Facades\DB;

class Pelayanan
{
	protected $dbsimrs = "sql_simrs";

	public function getPelayanan($kodePelayanan)
	{
		return DB::connection($this->dbsimrs)->table('pelayanan_bpjs')->where('kode', '=', $kodePelayanan)->first();
	}
	
}