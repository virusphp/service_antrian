<?php

namespace App\Http\Controllers\ApiSIMRS;

use App\Http\Controllers\Controller;
use App\Transform\TransformOperasi;
use Illuminate\Http\Request;
use App\Repository\Operasi;
use App\Validation\PostOperasi;
use App\Validation\PostListOperasi;

class OperationController extends Controller
{
    protected $operasi;

    public function __construct()
    {
        $this->operasi = new Operasi;
        $this->transform = new TransformOperasi;
    }

    public function getOperasi(Request $r, PostOperasi $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonApiBpjs(422, "Error Require Form", $message);    
        }


        $result = $this->operasi->postOperasi($r);
        dd($result);
        
        if ($result['code'] == 200) {
            unset($result['code']);
            return response()->jsonApiBpjs(200, "Sukses Registrasi", $result);
        }

        unset($result['code']);
        return response()->jsonApiBpjs(201, "Error Proses Insert", $result);
    }

    public function getRekapAntrian(Request $r, PostListOperasi $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonApiBpjs(422, "Error Require Form", $message);    
        }

        $result = $this->operasi->postRekap($r);

        if ($result['code'] == 200) {
            unset($result['code']);
            return response()->jsonApiBpjs(200, "Sukses", $result);
        }

        unset($result['code']);
        return response()->jsonApiBpjs(201, "Pencarian Tidak ditemukan ", $result);
    }
}