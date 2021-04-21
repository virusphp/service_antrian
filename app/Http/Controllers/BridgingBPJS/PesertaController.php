<?php

namespace App\Http\Controllers\BridgingBPJS;

use App\Service\Bpjs\Bridging;

class PesertaController extends BpjsController
{
    protected $bpjs;

    public function __construct()
    {
        parent::__construct();
        $this->bpjs = new Bridging($this->consid, $this->timestamp, $this->signature);
    }

    public function noKartu($noKartu, $tglSep)
    {
        $endpoint = 'Peserta/nokartu/'. $noKartu . "/tglSEP/" . $tglSep;
        $peserta = $this->bpjs->getRequest($endpoint);
        return $peserta;
    }

    public function noKtp($nik, $tglSep)
    {
        $endpoint = 'Peserta/nik/'. $nik . "/tglSEP/" . $tglSep;
        $peserta = $this->bpjs->getRequest($endpoint);
        return $peserta;
    }
}