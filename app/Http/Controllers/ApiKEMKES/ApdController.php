<?php

namespace App\Http\Controllers\ApiKEMKES;

use App\Service\Kemkes\Bridging;
use Illuminate\Http\Request;

class ApdController extends KemkesController
{
    protected $kemkes;

    public function __construct()
    {
        parent::__construct();
        $this->kemkes = new Bridging($this->rsid, $this->passid, $this->timestamp);
    }

    public function getAPD() 
    {
        $endpoint = "Fasyankes/apd";
        $apd = $this->kemkes->getRequest($endpoint);
        return $apd;
    }

    public function postAPD(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "Fasyankes/apd";
        $apd = $this->kemkes->postRequest($endpoint, $dataJson);
        return $apd;
    }

    public function updateAPD(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "Fasyankes/apd";
        $apd = $this->kemkes->putRequest($endpoint, $dataJson);
        return $apd;
    }

    public function deleteAPD(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "Fasyankes/apd";
        $apd = $this->kemkes->deleteRequest($endpoint, $dataJson);
        return $apd;
    }
}