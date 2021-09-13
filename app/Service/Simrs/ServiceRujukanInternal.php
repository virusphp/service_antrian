<?php

namespace App\Service\Simrs;

use App\Repository\Apm\Diagnosa;
use App\Repository\Apm\Faskes;
use App\Repository\Apm\Pelayanan;
use App\Repository\Apm\RujukanInternal;
use App\Repository\Apm\Poliklinik;

class ServiceRujukanInternal
{
	protected $rujukanInternal;
	protected $poliklinik;
	protected $diagnosa;
	protected $pelayanan;
	protected $faskes;

	public function __construct()
	{
		$this->rujukanInternal = new RujukanInternal;		
		$this->poliklinik = new Poliklinik;
		$this->pelayanan = new Pelayanan;
		$this->faskes = new Faskes;
		$this->diagnosa = new Diagnosa;
	}

	public function handleRujukanInternal($params)
	{	
		$rujukan = $this->rujukanInternal->checkRujukan($params);
		if ($rujukan) {
			$rujukan->kd_faskes = substr($rujukan->no_rujukan_bpjs, 0, 8);
			$pelayanan = substr($rujukan->no_reg, 0,2);
			$rujukan->kd_pelayanan = $pelayanan == "01" ? "2" : 1;

			$jenis_surat = $rujukan->jenis_surat;
			if ($jenis_surat == "SRI" || $jenis_surat == "SKO") {
				$poliBpjs = $this->poliklinik->getPoliBpjs($rujukan->kd_sub_unit_tujuan_rujuk);
				unset($rujukan->kd_sub_unit, $rujukan->kd_sub_unit_tujuan_rujuk);
				$rujukan->kd_poli_bpjs = $poliBpjs->kd_poli_dpjp;
			} else {
				$poliBpjs = $this->poliklinik->getPoliBpjs($rujukan->kd_sub_unit);
				unset($rujukan->kd_sub_unit, $rujukan->kd_sub_unit_tujuan_rujuk);
				$rujukan->kd_poli_bpjs = $poliBpjs->kd_poli_dpjp;
			}
		}

		$rujukan = $this->mapping($rujukan);

		return $rujukan;
	}

	protected function mapping($params)
	{
		$diagnosa = $this->diagnosa->getDiagnosa($params->kd_icd_bpjs);
		$pelayanan = $this->pelayanan->getPelayanan($params->kd_pelayanan);
		$poli = $this->poliklinik->getPoli($params->kd_poli_bpjs);
		$faskes = $this->faskes->getFaskes($params->kd_faskes);
		return [
			'rujukan' => 
				[
					'diagnosa' => $diagnosa,
					'pelayanan' => $pelayanan,
					'noKunjungan' => $params->no_rujukan,
					'peserta' => [
						'noKartu' => $params->no_kartu,
					],
					'poliRujukan' => $poli,
					'provPerujuk' => $faskes,
					'tglKunjungan' => $params->tgl_rujukan_bpjs,
					'noRujukanBpjs' => $params->no_rujukan_bpjs,
					'kodeDPJP' => $params->kode_dpjp
				]
		];
	}
}