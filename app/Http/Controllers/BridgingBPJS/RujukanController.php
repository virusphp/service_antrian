<?php

namespace App\Http\Controllers\BridgingBPJS;

use App\Service\Bpjs\Bridging;

class RujukanController extends BpjsController
{
    protected $bpjs;

    public function __construct()
    {
        parent::__construct();
        $this->bpjs = new Bridging($this->consid, $this->timestamp, $this->signature);
    }

    public function RujukanPcare($noRujukan)
    {
        $endpoint = "Rujukan/" . $noRujukan;
        $rujukan = $this->bpjs->getRequest($endpoint);
        return $rujukan;
    }

    public function RujukanRs($noRujukan)
    {
        $endpoint = "Rujukan/RS/" . $noRujukan;
        $rujukanRs = $this->bpjs->getRequest($endpoint);
        return $rujukanRs;
    }

    public function PesertaPcare($noKartu)
    {
        $endpoint = "Rujukan/Peserta/" . $noKartu;
        $rujukanPeserta = $this->bpjs->getRequest($endpoint);
        return $rujukanPeserta;
    }

    public function PesertaRs($noKartu)
    {
        $endpoint = "Rujukan/RS/Peserta/" . $noKartu;
        $rujukanPesertaRs = $this->bpjs->getRequest($endpoint);
        return $rujukanPesertaRs;
    }

    public function PesertaListPcare($noKartu)
    {
        $endpoint = "Rujukan/List/Peserta/" . $noKartu;
        $rujukanList = $this->bpjs->getRequest($endpoint);
        return $rujukanList;
    }

    public function PesertaListRs($noKartu)
    {
        $endpoint = "Rujukan/RS/List/Peserta/" . $noKartu;
        $rujukanListRs = $this->bpjs->getRequest($endpoint);
        return $rujukanListRs;
    }
}