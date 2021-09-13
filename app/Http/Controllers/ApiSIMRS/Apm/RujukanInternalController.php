<?php

namespace App\Http\Controllers\ApiSIMRS\Apm;

use App\Http\Controllers\Controller;
use App\Http\Resources\RujukanInternalResource;
use App\Service\Simrs\ServiceRujukanInternal;
use App\Validation\RujukanInternal;
use Illuminate\Http\Request;

class RujukanInternalController extends Controller
{
    protected $serviceRujukan;
    protected $rujukanInternal;

    public function __construct()
    {
        $this->serviceRujukan = new ServiceRujukanInternal;
        // $this->rujukanInternal = new 
    }

    public function getRujukanInternal(Request $r, RujukanInternal $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonSimrs(422, implode(",",$message));    
        }
        
        $rujukanInternal = $this->serviceRujukan->handleRujukanInternal($r);

        if (!$rujukanInternal) {
            return response()->jsonSimrs(201, "Terjadi kesalahan data input masih salah");
        }

         return response()->jsonSimrs(200, "Sukses", $rujukanInternal);
    }

}