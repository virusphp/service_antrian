<?php

namespace App\Http\Controllers\BridgingBPJS;

use App\Service\Bpjs\Bridging;
use Illuminate\Http\Request;

class SepController extends BpjsController
{
    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgingBpjs;
    }

    public function CariSep($noSep)
    {
        $endpoint = "SEP/" . $noSep;
        $sep = $this->bridging->getRequest($endpoint);
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
}