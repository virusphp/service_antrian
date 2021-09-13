<?php

namespace App\Http\Controllers\ApiKEMKES;

use App\Service\Kemkes\Bridging;
use Illuminate\Http\Request;

class ProfilController extends KemkesController
{
    protected $kemkes;

    public function __construct()
    {
        parent::__construct();
        $this->kemkes = new Bridging($this->rsid, $this->passid, $this->timestamp);
    }

    public function updatePassword(Request $request) 
    {
        $dataJson = $request->all();
        $endpoint = "Profil/Password";
        // dd($dataJson, $endpoint);
        $passwordProfil = $this->kemkes->postReqeustPassword($endpoint, $dataJson);
        return $passwordProfil;
    }

}