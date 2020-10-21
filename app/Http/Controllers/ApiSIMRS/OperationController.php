<?php

namespace App\Http\Controllers\ApiSIMRS;

use App\Http\Controllers\Controller;
use App\Transform\TransformOperasi;
use Illuminate\Http\Request;
use App\Repository\Operasi;
use App\Validation\PostOperasi;
use App\Validation\PostJadwal;

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
        
        if (!$result->count()) {
            $message = [
                "messageError" => "Perserta tidak mempunyai riwayat operasi!"
            ];
            return response()->jsonApiBpjs(201, "Data Tidak ada!", $message);
        }

        $transform = $this->transform->mapOperasi($result);

        return response()->jsonApiBpjs(200, "OK", $transform);
    }

    public function getJadwal(Request $r, PostJadwal $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonApiBpjs(422, "Error Require Form", $message);    
        }

        $result = $this->operasi->postJadwal($r);

        if (!$result->count()) {
            $message = [
                "messageError" => "Perserta tidak mempunyai riwayat operasi!"
            ];
            return response()->jsonApiBpjs(201, "Data Tidak ada!", $message);
        }

        $transform = $this->transform->mapJadwal($result);

        return response()->jsonApiBpjs(200, "OK", $transform);
    }
   
}