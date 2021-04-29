<?php

namespace App\Http\Controllers\ApiSIMRS\Android;

use App\Http\Controllers\Controller;
use App\Repository\Poliklinik;
use App\Transform\TransformPoliklinik;
use Illuminate\Http\Request;

class TarifPoliklinikController extends Controller
{
    protected $poli;
    protected $transform;

    public function __construct()
    {
        $this->poli = new Poliklinik;
        $this->transform = new TransformPoliklinik;
    }

    public function getListPoli()
    {
        $listPoli = $this->poli->getListPoli();
        $transform = $this->transform->mapListKarcis($listPoli);
        return response()->jsonApi(200, "OK", $transform);
    }

    public function getTarifPoli($kodePoli)
    {
        $tarifPoli = $this->poli->getTarifPoli($kodePoli);
        if (!$tarifPoli) {
            $message = "Kode poli salah sialahkan input dengan benar!";
            return response()->jsonApi(201, $message);
        }
        $transform = $this->transform->mapListKarcis($tarifPoli);

        return response()->jsonApi(200, "OK", $transform);
    }

}