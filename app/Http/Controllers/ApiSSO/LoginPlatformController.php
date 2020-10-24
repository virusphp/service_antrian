<?php

namespace App\Http\Controllers\ApiSSO;

use App\Http\Controllers\Controller;
use App\Repository\Access;
use App\Transform\TransformAccess;
use App\Validation\LoginPlatform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginPlatformController extends Controller
{
    protected $access;

    public function __construct()
    {
        $this->access = new Access;
        $this->transform = new TransformAccess;
    }

    public function Login(Request $r, LoginPlatform $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonApi(422, implode(",",$message));    
        }

        $data = ["username" => $r->username, "password" => $r->password];

        $access = $this->access->checkAccess($data);
        
        if (!$access) {
            $message = [
                "messageError" => "Username tidak di temukan!"
            ];
        
            return response()->jsonApi(201, $message["messageError"]);
        }

        if (!Hash::check($data['password'], $access->password)) {
            $message = [
                "messageError" => "Password tidak cocok silahkan ulangi!"
            ];

            if ($access->scope=="bpdjateng"){
                return response()->jsonApiBPD(403, $message["messageError"]);
            } else {
                return response()->jsonApiBpjs(403, $message["messageError"]);
            }
        } 

        $access = $this->access->profileAccess($data);

        $transform = $this->transform->mapLogin($access);
        // dd($transform);
        if ($access->scope=="bpdjateng"){
            return response()->jsonApiBPD(200, "Login Success!", $transform);
        } else {
            return response()->jsonApiBpjs(200, "OK", $transform);
        }
    }
}