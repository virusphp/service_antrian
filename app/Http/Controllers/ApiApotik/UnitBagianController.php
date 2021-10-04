<?php

namespace App\Http\Controllers\ApiApotik;

use App\Http\Controllers\Controller;
use App\Http\Resources\UnitResource;
use App\Repository\Apotik\UnitBagian;
use Illuminate\Http\Request;

class UnitBagianController extends Controller
{
    protected $unitBagian;
    protected $transform;

    public function __construct()
    {
        $this->unitBagian = new UnitBagian;
    }

    public function getUnit(Request $r)
    {
        $unitBagian = $this->unitBagian->getUnit($r);
        // dd($unitBagian);
        $transform = new UnitResource($unitBagian);
        return response()->jsonApi(200, 'OK', $transform);
    }
}