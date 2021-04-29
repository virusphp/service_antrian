<?php

namespace App\Http\Controllers\ApiSIMRS\Android;

use App\Http\Controllers\Controller;
use App\Repository\Pasien;
use App\Transform\TransformPasien;
use App\Validation\LoginUserAndroid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginAndroidController extends Controller
{
    protected $pasien;
    protected $transform;

    public function __construct()
    {
        $this->pasien = new Pasien;
        $this->transform = new TransformPasien;
    }

    public function loginAndroid(Request $r, LoginUserAndroid $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonApi(422, implode(",",$message));    
        }

        $checkUser = $this->pasien->dataUser($r);

        if (!$checkUser) {
            $message = "Nomer Rekamedik salah!!";
            return response()->jsonApi(201, $message);
        }

        if (!Hash::check($r->password, $checkUser->password)) {
            $message = "Password Salah Silahkan cek kembali";
            return response()->jsonApi(401, $message);
        }
       
        $result = $this->pasien->getBiodataPasien($checkUser->no_rm);

        $transform = $this->transform->mapperUserLogin($result);
        
        return response()->jsonApi(200, "Login Sukses!", $transform);

    }

}