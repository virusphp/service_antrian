<?php

namespace App\Http\Controllers\ApiApotik;

use App\Http\Controllers\Controller;
use App\Http\Resources\SatuanCollection;
use App\Http\Resources\SatuanResource;
use App\Repository\Apotik\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{

    protected $satuan;

    public function __construct()
    {
        $this->satuan = new Satuan;
    }

    public function getSatuan(Request $r)
    {
        $satuan = $this->satuan->getSatuan($r);
        $transform = new SatuanCollection($satuan);
        return response()->jsonApi(200, 'OK', $transform);
    }
}