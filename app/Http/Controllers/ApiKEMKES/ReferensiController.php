<?php

namespace App\Http\Controllers\ApiKEMKES;

use App\Service\Kemkes\Bridging;

class ReferensiController extends KemkesController
{
    protected $kemkes;

    public function __construct()
    {
        parent::__construct();
        $this->kemkes = new Bridging($this->rsid, $this->passid, $this->timestamp);
    }

    public function referensiTempatTidur() 
    {
        $endpoint = "Referensi/tempat_tidur";
        $tempatTidur = $this->kemkes->getRequest($endpoint);
        return $tempatTidur;
    }

    public function referensiUsiaMeninggal() 
    {
        $endpoint = "Referensi/usia_meninggal_probable";
        $usiaMeninggal = $this->kemkes->getRequest($endpoint);
        return $usiaMeninggal;
    }

    public function referensiKebutuhanSDM()
    {
        $endpoint = "Referensi/kebutuhan_sdm";
        $kebutuhanSDM = $this->kemkes->getRequest($endpoint);
        return $kebutuhanSDM;
    }

    public function referensiKebutuhanAPD()
    {
        $endpoint = "Referensi/kebutuhan_apd";
        $kebutuhanAPD = $this->kemkes->getRequest($endpoint);
        return $kebutuhanAPD;
    }
}