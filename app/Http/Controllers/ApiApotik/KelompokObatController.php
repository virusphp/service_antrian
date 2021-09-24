<?php

namespace App\Http\Controllers\ApiApotik;

use App\Http\Controllers\Controller;
use App\Http\Resources\KelompokObatCollection;
use App\Repository\Apotik\KelompokObat;
use Illuminate\Http\Request;

class KelompokObatController extends Controller
{
    protected $kelompok;

    public function __construct()
    {
        $this->kelompok = new KelompokObat;
    }

    public function getKelompok(Request $r)
    {
        $kelompok = $this->kelompok->getKelompokObat($r);
        // dd($kelompok);
        $transform = new KelompokObatCollection($kelompok);
        return response()->jsonApi(200, 'OK', $transform);
    }
}