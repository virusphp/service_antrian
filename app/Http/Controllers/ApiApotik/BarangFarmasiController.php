<?php

namespace App\Http\Controllers\ApiApotik;

use App\Http\Controllers\Controller;
use App\Repository\Apotik\BarangFarmasi;
use App\Transform\TransformBarang;
use Illuminate\Http\Request;

class BarangFarmasiController extends Controller
{
    protected $barang;
    protected $transform;

    public function __construct()
    {
        $this->barang = new BarangFarmasi;
        $this->transform = new TransformBarang;
    }

    public function getBarang(Request $r)
    {
        $barangFarmasi = $this->barang->getBarang($r);
        $transform = $this->transform->mapBarang($barangFarmasi);
        return response()->jsonApi(200, 'OK', $transform);
    }
}