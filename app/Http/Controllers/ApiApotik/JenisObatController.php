<?php

namespace App\Http\Controllers\ApiApotik;

use App\Http\Controllers\Controller;
use App\Http\Resources\JenisObatCollection;
use App\Repository\Apotik\JenisObat;
use Illuminate\Http\Request;

class JenisObatController extends Controller
{
    protected $jenisObat;

    public function __construct()
    {
        $this->jenisObat = new JenisObat;
    }

    public function getJenisObat(Request $r)
    {
        $jenisObat = $this->jenisObat->getJenisObat($r);
        $transform = new JenisObatCollection($jenisObat);
        return response()->jsonApi(200, 'OK', $transform);
    }
}