<?php

namespace App\Repository\Apm;

use Bpjs\Bridging\Vclaim\BridgeVclaim;

class Sep
{
    protected $serviceBpjs;

    public function __construct()
    {
        $this->serviceBpjs = new BridgeVclaim;
    }

    public function insertSep($data)
    {
        unset($data['request']['sep_internal']);
        $datajson = json_encode($data);
        $endpoiont = "SEP/2.0/insert";
        $sep = $this->serviceBpjs->postRequest($endpoiont, $datajson);
        return $sep;
    }

    public function jumlahSep($jnsRujukan, $noRujukan)
    {
        $endpoint = "Rujukan/JumlahSEP/" . $jnsRujukan . "/" . $noRujukan;
        $rujukansep = $this->serviceBpjs->getRequest($endpoint);
        return $rujukansep;
    }
}
