<?php

namespace App\Http\Controllers\BridgingBPJS;

use App\Service\Bpjs\Bridging;

class RencanaKontrolController extends BpjsController
{
    protected $bpjs;

    public function __construct()
    {
        parent::__construct();
        $this->bpjs = new Bridging($this->consid, $this->timestamp, $this->signature);
    }

    public function KontrolCariSep($noSep)
    {
        $endpoint = "RencanaKontrol/nosep/" . $noSep;
        $sep = $this->bpjs->getRequest($endpoint);
        return $sep;
    }

    public function KontrolCariSurat($noSurat)
    {
        $endpoint = "RencanaKontrol/noSuratKontrol/" . $noSurat;
        $noSurat = $this->bpjs->getRequest($endpoint);
        return $noSurat;
    }
}