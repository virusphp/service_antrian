<?php

namespace App\Http\Controllers\BridgingBPJS;

use Vclaim\Bridging\BridgingBpjs;

class MonitoringController extends BpjsController
{
    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgingBpjs;
    }
  
    public function Kunjungan($tglSep, $jnsPel)
    {
        $endpoint = "Monitoring/Kunjungan/Tanggal/" . $tglSep . "/jnsPelayanan/" . $jnsPel;
        $kunjungan = $this->bridging->getRequest($endpoint);
        return $kunjungan;
    }

    public function Klaim($tglPulang, $jnsPel, $status)
    {
        $endpoint = "Monitoring/Klaim/Tanggal/" . $tglPulang . "/jnsPelayanan/" . $jnsPel . "/Status/" . $status;
        $klaim = $this->bridging->getRequest($endpoint);
        return $klaim;
    }

    public function History($noKartu, $tglAwal, $tglAkhir)
    {
        $endpoint = "monitoring/HistoriPelayanan/NoKartu/" . $noKartu . "/tglAwal/" . $tglAwal . "/tglAkhir/" . $tglAkhir;
        $history = $this->bridging->getRequest($endpoint);
        return $history;
    }

    public function JasaRaharja($tglAwal, $tglAkhir)
    {
        $endpoint = "monitoring/JasaRaharja/tglMulai/" . $tglAwal . "/tglAkhir/" . $tglAkhir;
        $jasaRaharja = $this->bridging->getRequest($endpoint);
        return $jasaRaharja;

    }
}