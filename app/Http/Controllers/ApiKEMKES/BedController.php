<?php

namespace App\Http\Controllers\ApiKEMKES;

use App\Service\Kemkes\Bridging;
use Illuminate\Http\Request;

class BedController extends KemkesController
{
    protected $kemkes;

    public function __construct()
    {
        parent::__construct();
        $this->kemkes = new Bridging($this->rsid, $this->passid, $this->timestamp);
    }

    public function getTempatTidur() 
    {
        $endpoint = "Fasyankes";
        $tempatTidur = $this->kemkes->getRequest($endpoint);
        return $tempatTidur;
    }

    public function postTempatTidur(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "Fasyankes";
        $tempatTidur = $this->kemkes->postRequest($endpoint, $dataJson);
        return $tempatTidur;
    }

    public function updateTempatTidur(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "Fasyankes";
        $tempatTidur = $this->kemkes->putRequest($endpoint, $dataJson);
        return $tempatTidur;
    }

    public function deleteTempatTidur(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "Fasyankes";
        $tempatTidur = $this->kemkes->deleteRequest($endpoint, $dataJson);
        return $tempatTidur;
    }
}