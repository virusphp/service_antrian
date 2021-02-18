<?php

namespace App\Http\Controllers\ApiBankJateng;

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

    public function getTagihanPasien(Request $r, PostPasien $valid)
    {
        $validate = $valid->rules($r);
        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonApi('01', implode(",",$message));    
        }

        $pasien = $this->pasien->getPasien($r);        
        if (!$pasien) {
            $message = [
                "messageError" => "Data Pasien tidak di temukan!"
            ];        
            return response()->jsonApi('01', $message["messageError"]);;
        }
        
        $tagihan = $this->tagihan->getTagihanPasien($r);
        if($tagihan=='01'){
            $message = [
                "messageError" => "Data Tagihan Pasien tidak di temukan!"
            ];        
            return response()->jsonApi('01', $message["messageError"]);
        }else{
            if (!$tagihan->count()) {               
                $message = [
                    "messageError" => "Data Tagihan Pasien Sudah Dibayar"
                ];        
                return response()->jsonApi('02', $message["messageError"]);
            }     

            $transform = $this->transform->mapperTagihan($pasien, $tagihan); 
            return response()->jsonApi('00', "Data Tagihan Pasien Ditemukan", $transform);
        }        
    }
   
}