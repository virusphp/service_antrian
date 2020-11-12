<?php

namespace App\Http\Controllers\ApiSIMRS;

use App\Http\Controllers\Controller;
use App\Repository\Pasien;
use App\Repository\Tagihan;
use App\Transform\TransformTagihan;
use App\Validation\PostPasien;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    protected $pasien;

    public function __construct()
    {
        $this->pasien = new Pasien;
        $this->tagihan = new Tagihan;
        $this->transform = new TransformTagihan;
    }

    public function getTagihan(Request $r, PostPasien $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            // dd($validate->erros());
            $message = $valid->messages($validate->errors());
            return response()->jsonApiBpjs(422, implode(",",$message));    
        }

        $pasien = $this->pasien->getPasien($r);
        
        if (!$pasien) {
            $message = [
                "messageError" => "Data Pasien tidak di temukan!"
            ];
        
            return response()->jsonApi(201, $message["messageError"]);;
        }
        
        $tagihan = $this->tagihan->getTagihan($r);

        if (!$tagihan->count()) {
            $message = [
                "messageError" => "Data Tagihan Pasien tidak di temukan!"
            ];
        
            return response()->jsonApi(201, $message["messageError"]);;
        }

        $transform = $this->transform->mapperTagihan($pasien, $tagihan);

        return response()->jsonApi(200, "OK", $transform);
    }
}