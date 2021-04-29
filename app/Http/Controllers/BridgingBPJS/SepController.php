<?php

namespace App\Http\Controllers\BridgingBPJS;

use App\Service\Bpjs\Bridging;
use Illuminate\Http\Request;

class SepController extends BpjsController
{
    protected $bpjs;

    public function __construct()
    {
        parent::__construct();
        $this->bpjs = new Bridging($this->consid, $this->timestamp, $this->signature);
    }

    public function CariSep($noSep)
    {
        $endpoint = "SEP/" . $noSep;
        $sep = $this->bpjs->getRequest($endpoint);
        return $sep;
    }

    public function InsertSep(Request $request)
    {
        $dataJson = json_encode($request->all());
        $endpoint = "SEP/1.1/insert"; 
        $sep = $this->bpjs->postRequest($endpoint, $dataJson);
        return $sep;
    }

    public function DeleteSep(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "SEP/delete";
        $sep = $this->bpjs->deleteRequest($endpoint, $dataJson);
        return $sep;
    }
}