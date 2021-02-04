<?php

namespace App\Http\Controllers\ApiSIMRS;

use App\Http\Controllers\Controller;
use App\Repository\Kamar;

class KamarController extends Controller
{
    protected $kamar;

    public function __construct()
    {
        $this->kamar = new Kamar;
    }

    public function getListKamarKemkes()
    {
        $listTempatTidur = $this->kamar->getListBedKemkes();
        return response()->json($listTempatTidur);
    }

    public function getListKamarSiranap()
    {
        $listTempatTidur = $this->kamar->getListBedSiranap();
        return response()->json($listTempatTidur);
    }

    public function getListKamarSiranapXml()
    {
        $listTempatTidur = $this->kamar->getListBedSiranapXml();
        $content = view('xml.siranap', compact('listTempatTidur'));
        return response($content,200)->header('Content-Type', 'text/xml');
    }
}