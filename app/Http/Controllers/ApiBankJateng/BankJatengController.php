<?php

namespace App\Http\Controllers\ApiBankJateng;
use App\Http\Controllers\Controller;
use App\Repository\Tagihan;
use App\Transform\TransformTagihanBayar;
use App\Validation\PostTagihanBayar;
use Illuminate\Http\Request;

class BankJatengController extends Controller
{
    protected $pasien;

    public function __construct()
    {
        $this->tagihan = new Tagihan;
        $this->transform = new TransformTagihanBayar;
    }

    public function bayarTagihan(Request $r, PostTagihanBayar $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonApi('01', implode(",",$message));    
        }
       
        $bayartagihan = $this->tagihan->bayarTagihan($r);
        if (!$bayartagihan->count()) {
            $message = [
                "messageError" => "Error Exception"
            ];        
            return response()->jsonApi('05', $message["messageError"]);;
        }        
        $tgl_reg = $r['pasien.tanggal_registrasi'];
        $transform = $this->transform->mapperTagihanBayar($bayartagihan,$tgl_reg);
        return response()->jsonApi('04', "Tagihan Berhasil disimpan", $transform);
        
    }
}