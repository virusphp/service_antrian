<?php

namespace App\Http\Controllers\ApiBankJateng;
use App\Http\Controllers\Controller;
use App\Repository\Pasien;
use App\Repository\Tagihan;
use App\Validation\PostTagihanBayar;
use Illuminate\Http\Request;

class BankJatengController extends Controller
{
    protected $pasien;

    public function __construct()
    {
        $this->tagihan = new Tagihan;
    }

    public function bayarTagihan(Request $r, PostTagihanBayar $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonApiBpjs(422, implode(",",$message));    
        }
       
        $bayartagihan = $this->tagihan->bayarTagihan($r);
        
        // if (!$bayartagihan) {
        //     $message = [
        //         "messageError" => "Data Pasien tidak di temukan!"
        //     ];
        
        //     return response()->jsonApi(201, $message["messageError"]);;
        // }

    }
}