<?php

namespace App\Repository\Apm;

use Illuminate\Support\Facades\DB;

class RujukanInternal
{
	protected $dbsimrs = "sql_simrs";

	public function checkRujukan($params)
	{
		$dari = date('Y-m-d', strtotime('-90 days', strtotime($params->tgl_reg)));
		$noRujukan = (string) substr($params->no_rujukan, 0,6);
		// dd($dari, $params->tgl_reg);
		
		return DB::connection($this->dbsimrs)->table('surat_rujukan_internal as ri')
			->select('ri.no_reg','ri.no_rujukan','ri.kd_icd_bpjs','ri.no_rujukan_bpjs','ri.tgl_rujukan_bpjs','ri.jenis_surat','ri.kd_sub_unit',
					 'ri.kd_sub_unit','ri.kd_sub_unit_tujuan_rujuk','pg.kode_dpjp','pp.no_kartu')
			->join('dbsimrs.dbo.pegawai as pg', 'ri.kd_dokter','pg.kd_pegawai')
			->join('registrasi as r', function($join) {
				$join->on('ri.no_reg','=','r.no_reg')
					->join('penjamin_pasien as pp',function ($join) {
						$join->on('r.kd_penjamin', '=', 'pp.kd_penjamin')
							->on('r.no_rm', '=', 'pp.no_rm');
					});
			})
			->whereBetween('tgl_rujukan_bpjs', [$dari, $params->tgl_reg])
			->whereRaw("SUBSTRING(no_rujukan, 7, 6) = '".$noRujukan."'")
			->first();
	}
	
}