<?php

namespace App\Http\Controllers\BridgingBPJS;

use App\Service\Bpjs\Bridging;

class MonitoringController extends BpjsController
{
    protected $bpjs;

    public function __construct()
    {
        parent::__construct();
        $this->bpjs = new Bridging($this->consid, $this->timestamp, $this->signature);
    }

    public function Kunjungan($tglSep, $jnsPel)
    {
        $endpoint = "Monitoring/Kunjungan/Tanggal/" . $tglSep . "/jnsPelayanan/" . $jnsPel;
        $kunjungan = $this->bpjs->getRequest($endpoint);
        return $kunjungan;
    }

    public function Klaim($tglPulang, $jnsPel, $status)
    {
        $endpoint = "Monitoring/Klaim/Tanggal/" . $tglPulang . "/jnsPelayanan/" . $jnsPel . "/Status/" . $status;
        $klaim = $this->bpjs->getRequest($endpoint);
        return $klaim;
    }

    public function History($noKartu, $tglAwal, $tglAkhir)
    {
        $endpoint = "monitoring/HistoriPelayanan/NoKartu/" . $noKartu . "/tglAwal/" . $tglAwal . "/tglAkhir/" . $tglAkhir;
        $history = $this->bpjs->getRequest($endpoint);
        return $history;
    }

    public function JasaRaharja($tglAwal, $tglAkhir)
    {
        $endpoint = "monitoring/JasaRaharja/tglMulai/" . $tglAwal . "/tglAkhir/" . $tglAkhir;
        // dd($endpoint);
        $jasaRaharja = $this->bpjs->getRequest($endpoint);
        return $jasaRaharja;

    }
}