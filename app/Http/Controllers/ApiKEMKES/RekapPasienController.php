<?php

namespace App\Http\Controllers\ApiKEMKES;

use App\Service\Kemkes\Bridging;
use Illuminate\Http\Request;

class RekapPasienController extends KemkesController
{
    protected $kemkes;

    public function __construct()
    {
        parent::__construct();
        $this->kemkes = new Bridging($this->rsid, $this->passid, $this->timestamp);
    }

    public function getPasienMasuk() 
    {
        $endpoint = "LapV2/PasienMasuk";
        $pasienMasuk = $this->kemkes->getRequest($endpoint);
        return $pasienMasuk;
    }

    public function postPasienMasuk(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "LapV2/PasienMasuk";
        $pasienMasuk = $this->kemkes->postRequest($endpoint, $dataJson);
        return $pasienMasuk;
    }

    public function deleteTempatTidur(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "LapV2/PasienMasuk";
        $tempatTidur = $this->kemkes->deleteRequest($endpoint, $dataJson);
        return $tempatTidur;
    }

    public function getPasienKomorbid()
    {
        $endpoint = "LapV2/PasienDirawatKomorbid";
        $pasienKomorbid = $this->kemkes->getRequest($endpoint);
        return $pasienKomorbid;
    }

    public function postPasienKomorbid(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "LapV2/PasienDirawatKomorbid";
        $pasienKomorbid = $this->kemkes->postRequest($endpoint, $dataJson);
        return $pasienKomorbid;
    }

    public function getPasienTanpaKomorbid()
    {
        $endpoint = "LapV2/PasienDirawatTanpaKomorbid";
        $tanpaKomorbid = $this->kemkes->getRequest($endpoint);
        return $tanpaKomorbid;
    }

    public function postPasienTanpaKomorbid(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "LapV2/PasienDirawatTanpaKomorbid";
        $tanpaKomorbid = $this->kemkes->postRequest($endpoint, $dataJson);
        return $tanpaKomorbid;
    }

    public function getPasienKeluar() 
    {
        $endpoint = "LapV2/PasienKeluar";
        $pasienKeluar = $this->kemkes->getRequest($endpoint);
        return $pasienKeluar;
    }

    public function postPasienKeluar(Request $request) 
    {
        $dataJson = $request->all();
        $endpoint = "LapV2/PasienKeluar";
        $pasienKeluar = $this->kemkes->postRequest($endpoint, $dataJson);
        return $pasienKeluar;
    }
}