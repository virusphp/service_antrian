<?php

namespace App\Http\Controllers\ApiSSO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transform\TransformAccess;
use App\Validation\RegistrasiPlatform;
use App\Repository\Access;

class RegistrasiPlatrofmController extends Controller
{
    protected $access;

    public function __construct()
    {
        $this->access = new Access;
        $this->transform = new TransformAccess;
    }

    public function Register(Request $r, RegistrasiPlatform $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonApi(422, "Error Require Form", $message);    
        }

        $access = $this->access->save($r);

        if ($access) {
            $transform = $this->transform->mapRegister($access);
            return response()->jsonApi(200, "Registrasi Berhasil!", $transform);
        }

        $message = [
            "messageError" => "Internal server error!"
        ];

        return response()->jsonApi(500, "Terjadi Error Server!!", $message);
    }

}