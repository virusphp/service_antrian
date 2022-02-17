<?php

namespace App\Http\Controllers\BridgingBPJS;

use Vclaim\Bridging\BridgingBpjs;

class PesertaController extends BpjsController
{
    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgingBpjs;
    }

    public function noKartu($noKartu, $tglSep)
    {
        $endpoint = 'Peserta/nokartu/'. $noKartu . "/tglSEP/" . $tglSep;
        $peserta = $this->bridging->getRequest($endpoint);
        return $peserta;
    }

    public function noKtp($nik, $tglSep)
    {
        $endpoint = 'Peserta/nik/'. $nik . "/tglSEP/" . $tglSep;
        $peserta = $this->bridging->getRequest($endpoint);
        return $peserta;
    }
}