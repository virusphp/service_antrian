<?php

namespace App\Http\Controllers\ApiSIMRS;

use App\Http\Controllers\Controller;
use App\Transform\TransformAntrian;
use Illuminate\Http\Request;
use App\Repository\Antrian;
use App\Validation\PostAntrian;

class AntrianController extends Controller
{
    protected $antrian;

    public function __construct()
    {
        $this->antrian = new Antrian;
        $this->transform = new TransformAntrian;
    }
    public function Register(Request $r, PostAntrian $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonApi(422, "Error Require Form", $message);    
        }

        $antrian = $this->antrian->postAntrian($r);
        return $antrian;

    }
}