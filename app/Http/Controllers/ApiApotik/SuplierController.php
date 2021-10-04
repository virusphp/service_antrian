<?php

namespace App\Http\Controllers\ApiApotik;

use App\Http\Controllers\Controller;
use App\Http\Resources\SuplierCollection;
use App\Repository\Apotik\Suplier;
use Illuminate\Http\Request;

class SuplierController extends Controller
{
    protected $suplier;

    public function __construct()
    {
        $this->suplier = new Suplier;
    }

    public function getSuplier(Request $r)
    {
        $suplier = $this->suplier->getSuplier($r);
        $transform = new SuplierCollection($suplier);
        return response()->jsonApi(200, 'OK', $transform);
    }
}