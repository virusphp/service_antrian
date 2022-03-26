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
        $sep = $this->bridging->getRequestSep($endpoint);
        return $sep;
    }

    public function InsertSep(Request $request)
    {
        $dataJson = json_encode($request->all());
        $endpoint = "SEP/1.1/insert"; 
        $sep = $this->bridging->postRequest($endpoint, $dataJson);
        return $sep;
    }

    public function DeleteSep(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "SEP/delete";
        $sep = $this->bridging->deleteRequest($endpoint, $dataJson);
        return $sep;
    }

    public function UpdatePlg(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "SEP/2.0/updtglplg";
        dd($dataJson, $endpoint);
        $sep = $this->bridging->putRequest($endpoint, $dataJson);
        return $sep;
    }
}