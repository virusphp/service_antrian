<?php

namespace App\Http\Controllers\BridgingBPJS;

use App\Service\Bpjs\Bridging;

class ReferensiController
{
    protected $briding;

    public function __construct()
    {
        $this->bridging = new Bridging();
    }

    public function diagnosa($kode)
    {
        $endpoint = "referensi/diagnosa/". $kode;
        $diagnosa = $this->bridging->getRequest($endpoint);
        return $diagnosa;
    }

    public function poli($kode)
    {
        $endpoint = "referensi/poli/" . $kode;
        $poli = $this->bpjs->getRequest($endpoint);
        $result = json_decode($poli);
        if ($result->metaData->code == "200" && !isset($result->response->poli)) {
            return $this->responseBpjs($result);
        }
        return json_encode($result);
    }

    public function faskes($kodeNama, $jenisFaskes)
    {
        $endpoint = "referensi/faskes/" . $kodeNama . "/" . $jenisFaskes;
        $faskes = $this->bpjs->getRequest($endpoint);
        $result = json_decode($faskes);
        if ($result->metaData->code == "200" && !isset($result->response->faskes)) {
            return $this->responseBpjs($result);
        }
        return json_encode($result);
    }

    public function dpjp($jnsPel, $tglPel, $subSpesial)
    {
        $endpoint = "referensi/dokter/pelayanan/" . $jnsPel . "/tglPelayanan/" . $tglPel. "/Spesialis/". $subSpesial;
        $dpjp = $this->bpjs->getRequest($endpoint);
        $result = json_decode($dpjp);
        if ($result->metaData->code == "200" && !isset($result->response->list)) {
            return $this->responseBpjs($result);
        }
        return json_encode($result);
    }

    public function propinsi()
    {
        $endpoint = "referensi/propinsi";
        $propinsi = $this->bpjs->getRequest($endpoint);
        $result = json_decode($propinsi);
        if ($result->metaData->code == "200" && !isset($result->response->list)) {
            return $this->responseBpjs($result);
        }
        return json_encode($result);
    }

    public function kabupaten($kodePropinsi)
    {
        $endpoint = "referensi/kabupaten/propinsi/" . $kodePropinsi;
        $kabupaten = $this->bpjs->getRequest($endpoint);
        $result = json_decode($kabupaten);
        if ($result->metaData->code == "200" && !isset($result->response->list)) {
            return $this->responseBpjs($result);
        }
        return json_encode($result);
    }

    public function kecamatan($kodeKabupaten)
    {
        $endpoint = "referensi/kecamatan/kabupaten/" . $kodeKabupaten;
        $kecamatan = $this->bpjs->getRequest($endpoint);
        $result = json_decode($kecamatan);
        if ($result->metaData->code == "200" && !isset($result->response->list)) {
            return $this->responseBpjs($result);
        }
        return json_encode($result);
    }

    public function procedure($kodeNama)
    {
        $endpoint = "referensi/procedure/" . $kodeNama;
        $procedure = $this->bpjs->getRequest($endpoint);
        $result = json_decode($procedure);
        if ($result->metaData->code == "200" && !isset($result->response->procedure)) {
            return $this->responseBpjs($result);
        }
        return json_encode($result);
    }

    public function kelas()
    {
        $endpoint = "referensi/kelasrawat";
        $kelas = $this->bpjs->getRequest($endpoint);
        $result = json_decode($kelas);
        if ($result->metaData->code == "200" && !isset($result->response->list)) {
            return $this->responseBpjs($result);
        }
        return json_encode($result);
    }

    public function dokter($namaDokter)
    {
        $endpoint = "referensi/dokter/". $namaDokter;
        $dokter = $this->bpjs->getRequest($endpoint);
        $result = json_decode($dokter);
        if ($result->metaData->code == "200" && !isset($result->response->list)) {
            return $this->responseBpjs($result);
        }
        return json_encode($result);
    }

    public function spesialistik()
    {
        $endpoint = "referensi/spesialistik";
        $spesialistik = $this->bpjs->getRequest($endpoint);
        return $spesialistik;
    }

    public function ruang()
    {
        $endpoint = "referensi/ruangrawat";
        $ruang = $this->bpjs->getRequest($endpoint);
        return $ruang;
    }

    public function caraKeluar()
    {
        $endpoint = "referensi/carakeluar";
        $caraKeluar = $this->bpjs->getRequest($endpoint);
        return $caraKeluar;
    }

    public function pascaPulang()
    {
        $endpoint = "referensi/pascapulang";
        $pascaPulang = $this->bpjs->getRequest($endpoint);
        return $pascaPulang;
    }

}