<?php

namespace App\Repository\Apm;

use Illuminate\Support\Facades\DB;

class Diagnosa
{
	protected $dbsimrs = "sql_simrs";

	public function getDiagnosa($kodeDiagnosa)
	{
		return DB::connection($this->dbsimrs)->table('diagnosa_bpjs')->where('kode', '=', $kodeDiagnosa)->first();
	}
	
}