<?php

namespace App\Http\Controllers\BridgingBPJS;

use Bpjs\Bridging\Vclaim\BridgeVclaim;
use Illuminate\Http\Request;

class RujukanController extends BpjsController
{
    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgeVclaim;
    }

    public function RujukanPcare($noRujukan)
    {
        $endpoint = "Rujukan/" . $noRujukan;
        $rujukan = $this->bridging->getRequest($endpoint);
        return $rujukan;
    }

    public function RujukanRs($noRujukan)
    {
        $endpoint = "Rujukan/RS/" . $noRujukan;
        $rujukanRs = $this->bridging->getRequest($endpoint);
        return $rujukanRs;
    }

    public function jumlahSep($jnsRujukan, $noRujukan)
    {
        $endpoint = "Rujukan/JumlahSEP/" . $jnsRujukan . "/" . $noRujukan;
        $rujukansep = $this->bridging->getRequest($endpoint);
        return $rujukansep;
    }

    public function PesertaPcare($noKartu)
    {
        $endpoint = "Rujukan/Peserta/" . $noKartu;
        $rujukanPeserta = $this->bridging->getRequest($endpoint);
        return $rujukanPeserta;
    }

    public function PesertaRs($noKartu)
    {
        $endpoint = "Rujukan/RS/Peserta/" . $noKartu;
        $rujukanPesertaRs = $this->bridging->getRequest($endpoint);
        return $rujukanPesertaRs;
    }

    public function PesertaListPcare($noKartu)
    {
        $endpoint = "Rujukan/List/Peserta/" . $noKartu;
        $rujukanList = $this->bridging->getRequest($endpoint);
        return $rujukanList;
    }

    public function PesertaListRs($noKartu)
    {
        $endpoint = "Rujukan/RS/List/Peserta/" . $noKartu;
        $rujukanListRs = $this->bridging->getRequest($endpoint);
        return $rujukanListRs;
    }

    public function DeleteRujukan(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "Rujukan/delete";
        $deleteRujukan = $this->bridging->deleteRequest($endpoint, $dataJson);
        return $deleteRujukan;
    }
}
