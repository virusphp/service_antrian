<?php

namespace App\Http\Controllers\ApiApotik;

use App\Http\Controllers\Controller;
use App\Http\Resources\GolonganObatCollection;
use App\Repository\Apotik\GolonganObat;
use Illuminate\Http\Request;

class GolonganController extends Controller
{
    protected $golonganObat;

    public function __construct()
    {
        $this->golonganObat = new GolonganObat;
    }

    public function getGolonganObat(Request $r)
    {
        $golonganObat = $this->golonganObat->getGolonganObat($r);
        $transform = new GolonganObatCollection($golonganObat);
        return response()->jsonApi(200, 'OK', $transform);
    }
}