<?php

namespace App\Http\Controllers\ApiSIMRS\Android;

use App\Http\Controllers\Controller;
use App\Repository\Pasien;
use App\Transform\TransformPasien;
use App\Validation\RegistrasiUserAndroid;
use Illuminate\Http\Request;

class RegistrasiAndroidController extends Controller
{
    protected $pasien;
    protected $transform;

    public function __construct()
    {
        $this->pasien = new Pasien;
        $this->transform = new TransformPasien;
    }

    public function registrasiAndroid(Request $r, RegistrasiUserAndroid $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonApi(422, implode(",",$message));    
        }

        $checkDataPasien = $this->pasien->dataPasien($r);

        if (!$checkDataPasien) {
            $message = "Data Tidak di temukan silahkan cek NO RM dan Tanggal Lahir!!";
            return response()->jsonApi(201, $message);
        }

        $result = $this->pasien->insertUserLogin($r);

        if (!$result) {
            $message = "Pendaftaran silahkan lengkapi data dengan benar!";
            return respone()->jsonApi(201, $message);
        }

        $transform = $this->transform->mapperRegisterUser($r);
        
        return response()->jsonApi(200, "Pendaftaran Sukses!", $transform);

    }

}