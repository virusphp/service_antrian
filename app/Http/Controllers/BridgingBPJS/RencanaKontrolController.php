<?php

namespace App\Http\Controllers\BridgingBPJS;

use Bpjs\Bridging\Vclaim\BridgeVclaim;
use Illuminate\Http\Request;

class RencanaKontrolController extends BpjsController
{
    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgeVclaim;
    }

    public function DataDokter($jnsKontrol, $kodePoli, $tglKontrol)
    {
        $endpoint = "RencanaKontrol/JadwalPraktekDokter/JnsKontrol/". $jnsKontrol. "/KdPoli/".$kodePoli."/TglRencanaKontrol/".$tglKontrol;
        $dataDokter = $this->bridging->getRequest($endpoint);
        return $dataDokter;
    }
  
    public function DataPoli($jnsKontrol, $nomor, $tglKontrol)
    {
        $endpoint = "RencanaKontrol/ListSpesialistik/JnsKontrol/". $jnsKontrol. "/nomor/".$nomor."/TglRencanaKontrol/".$tglKontrol;
        $dataPoli = $this->bridging->getRequest($endpoint);
        return $dataPoli;
    }

    public function DataSuratkontrol($tglAwal, $tglAkhir,$filter )
    {
        $endpoint = "RencanaKontrol/ListRencanaKontrol/tglAwal/". $tglAwal. "/tglAkhir/".$tglAkhir."/filter/".$filter;
        $dataSurat = $this->bridging->getRequest($endpoint);
        return $dataSurat;
    }

    public function DataSuratkontrolByKartu($bulan, $tahun, $nokartu, $filter)
    {
        // dd($bulan, $tahun, $nokartu);
        $endpoint = "RencanaKontrol/ListRencanaKontrol/Bulan/{$bulan}/Tahun/{$tahun}/NoKartu/{$nokartu}/filter/{$filter}";
        $dataSurat = $this->bridging->getRequest($endpoint);
        return $dataSurat;
    }

    public function CariSurat($noSurat)
    {
        $endpoint = "RencanaKontrol/noSuratKontrol/" . $noSurat;
        $nomorSurat = $this->bridging->getRequest($endpoint);
        return $nomorSurat;
    }

    public function CariSep($noSep)
    {
        $endpoint = "RencanaKontrol/nosep/" . $noSep;
        $nomorSep = $this->bridging->getRequest($endpoint);
        return $nomorSep;
    }

    public function DeleteSurat(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "RencanaKontrol/Delete";
        $deleteSurat = $this->bridging->deleteRequest($endpoint, $dataJson);
        return $deleteSurat;
    }

    public function UpdateSurat(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "RencanaKontrol/Update";
        $updateSurat = $this->bridging->putRequest($endpoint, $dataJson);
        return $updateSurat;
    }

    public function InsertSurat(Request $request)
    {
        $dataJson = $request->all();
        $endpoint = "RencanaKontrol/Insert";
        $insertSurat = $this->bridging->postRequest($endpoint, $dataJson);
        return $insertSurat;
    }
}