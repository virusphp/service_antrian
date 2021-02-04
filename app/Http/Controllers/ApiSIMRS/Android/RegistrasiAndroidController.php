<?php

namespace App\Http\Controllers\ApiSIMRS\Android;

use App\Http\Controllers\Controller;
use App\Repository\Pasien;
use App\Validation\RegistrasiUserAndroid;
use Illuminate\Http\Request;

class RegistrasiAndroidController extends Controller
{
    protected $pasien;

    public function __construct()
    {
        $this->pasien = new Pasien;
    }

    public function RegistrasiAndroid(Request $r, RegistrasiUserAndroid $valid)
    {
        dd("SAMPAI SINI");
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonApi(422, implode(",",$message));    
        }

        $checkDataPasien = $this->pasien->dataPasien($r); 
        dd($checkDataPasien);


    }

}