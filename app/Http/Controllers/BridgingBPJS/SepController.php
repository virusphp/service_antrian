<?php

namespace App\Http\Controllers\BridgingBPJS;

use Bpjs\Bridging\Vclaim\BridgeVclaim;
use Illuminate\Http\Request;

class SepController extends BpjsController
{
    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgeVclaim;
    }

    public function CariSep($noSep)
    {
        $endpoint = "SEP/" . $noSep;
        $sep = $this->bridging->getRequestNew($endpoint); // Reuqest khusus sep
        return $sep;
    }

    public function CariSepInternal($noSep)
    {
        $endpoint = "SEP/Internal/" . $noSep;
        $sep = $this->bridging->getRequestNew($endpoint); // Reuqest khusus sep
        return $sep;
    }

    public function InsertSep(Request $request)
    {
        $dataJson = json_encode($request->all());
        $endpoint = "SEP/2.0/insert"; 
        $sep = $this->bridging->postRequest($endpoint, $dataJson);
        return $sep;
    }

    public function DeleteSep(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "SEP/2.0/delete";
        // dd($endpoint);
        $sep = $this->bridging->deleteRequest($endpoint, $dataJson);
        return $sep;
    }

    public function UpdatePlg(Request $request)
    {
        $dataJson = json_encode($request->all());
        $endpoint = "SEP/2.0/updtglplg";
        $sep = $this->bridging->putRequest($endpoint, $dataJson);
        return $sep;
    }
}