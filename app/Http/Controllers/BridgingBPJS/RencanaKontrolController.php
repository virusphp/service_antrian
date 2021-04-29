<?php

namespace App\Http\Controllers\BridgingBPJS;

use App\Service\Bpjs\Bridging;
use Illuminate\Http\Request;

class RencanaKontrolController extends BpjsController
{
    protected $bpjs;

    public function __construct()
    {
        parent::__construct();
        $this->bpjs = new Bridging($this->consid, $this->timestamp, $this->signature);
    }

    public function DataDokter($jnsKontrol, $kodePoli, $tglKontrol)
    {
        $endpoint = "RencanaKontrol/JadwalPraktekDokter/JnsKontrol/". $jnsKontrol. "/KdPoli/".$kodePoli."/TglRencanaKontrol/".$tglKontrol;
        $dataDokter = $this->bpjs->getRequest($endpoint);
        return $dataDokter;
    }
  
    public function DataPoli($jnsKontrol, $nomor, $tglKontrol)
    {
        $endpoint = "RencanaKontrol/ListSpesialistik/JnsKontrol/". $jnsKontrol. "/nomor/".$nomor."/TglRencanaKontrol/".$tglKontrol;
        $dataPoli = $this->bpjs->getRequest($endpoint);
        return $dataPoli;
    }

    public function DataSuratkontrol($tglAwal, $tglAkhir,$filter )
    {
        $endpoint = "RencanaKontrol/ListRencanaKontrol/tglAwal/". $tglAwal. "/tglAkhir/".$tglAkhir."/filter/".$filter;
        $dataSurat = $this->bpjs->getRequest($endpoint);
        return $dataSurat;
    }

    public function CariSurat($noSurat)
    {
        $endpoint = "RencanaKontrol/noSuratKontrol/" . $noSurat;
        $nomorSurat = $this->bpjs->getRequest($endpoint);
        return $nomorSurat;
    }

    public function CariSep($noSep)
    {
        $endpoint = "RencanaKontrol/nosep/" . $noSep;
        $nomorSep = $this->bpjs->getRequest($endpoint);
        return $nomorSep;
    }

    public function DeleteSurat(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "RencanaKontrol/Delete";
        $deleteSurat = $this->bpjs->deleteRequest($endpoint, $dataJson);
        return $deleteSurat;
    }

    public function UpdateSurat(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "RencanaKontrol/Update";
        $updateSurat = $this->bpjs->putRequest($endpoint, $dataJson);
        return $updateSurat;
    }

    public function InsertSurat(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "RencanaKontrol/Insert";
        $insertSurat = $this->bpjs->postRequest($endpoint, $dataJson);
        return $insertSurat;
    }
}