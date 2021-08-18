<?php

namespace App\Http\Controllers\ApiKEMKES;

use App\Service\Kemkes\Bridging;
use Illuminate\Http\Request;

class SdmController extends KemkesController
{
    protected $kemkes;

    public function __construct()
    {
        parent::__construct();
        $this->kemkes = new Bridging($this->rsid, $this->passid, $this->timestamp);
    }

    public function getSDM() 
    {
        $endpoint = "Fasyankes/sdm";
        $sdm = $this->kemkes->getRequest($endpoint);
        return $sdm;
    }

    public function postSDM(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "Fasyankes/sdm";
        $sdm = $this->kemkes->postRequest($endpoint, $dataJson);
        return $sdm;
    }

    public function updateSDM(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "Fasyankes/sdm";
        $sdm = $this->kemkes->putRequest($endpoint, $dataJson);
        return $sdm;
    }

    public function deleteSDM(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "Fasyankes/sdm";
        $sdm = $this->kemkes->deleteRequest($endpoint, $dataJson);
        return $sdm;
    }
}