<?php

namespace App\Http\Controllers\BridgingBPJS;

use Bpjs\Bridging\Vclaim\BridgeVclaim;

class ReferensiController
{
    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgeVclaim;
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
        $poli = $this->bridging->getRequest($endpoint);
        return $poli;
    }

    public function faskes($kodeNama, $jenisFaskes)
    {
        $endpoint = "referensi/faskes/" . $kodeNama . "/" . $jenisFaskes;
        $faskes = $this->bridging->getRequest($endpoint);
        return $faskes;
    }

    public function dpjp($jnsPel, $tglPel, $subSpesial)
    {
        $endpoint = "referensi/dokter/pelayanan/" . $jnsPel . "/tglPelayanan/" . $tglPel. "/Spesialis/". $subSpesial;
        $dpjp = $this->bridging->getRequest($endpoint);
        return $dpjp;
    }

    public function propinsi()
    {
        $endpoint = "referensi/propinsi";
        $propinsi = $this->briding->getRequest($endpoint);
        return $propinsi;
    }

    public function kabupaten($kodePropinsi)
    {
        $endpoint = "referensi/kabupaten/propinsi/" . $kodePropinsi;
        $kabupaten = $this->bridging->getRequest($endpoint);
        return $kabupaten;
    }

    public function kecamatan($kodeKabupaten)
    {
        $endpoint = "referensi/kecamatan/kabupaten/" . $kodeKabupaten;
        $kecamatan = $this->bridging->getRequest($endpoint);
        return $kecamatan;
    }

    public function procedure($kodeNama)
    {
        $endpoint = "referensi/procedure/" . $kodeNama;
        $procedure = $this->bridging->getRequest($endpoint);
        return $procedure;
    }

    public function kelas()
    {
        $endpoint = "referensi/kelasrawat";
        $kelas = $this->bridging->getRequest($endpoint);
        return $kelas;
    }

    public function dokter($namaDokter)
    {
        $endpoint = "referensi/dokter/". $namaDokter;
        $dokter = $this->bridging->getRequest($endpoint);
        return $dokter;
    }

    public function spesialistik()
    {
        $endpoint = "referensi/spesialistik";
        $spesialistik = $this->bridging->getRequest($endpoint);
        return $spesialistik;
    }

    public function ruang()
    {
        $endpoint = "referensi/ruangrawat";
        $ruang = $this->bridging->getRequest($endpoint);
        return $ruang;
    }

    public function caraKeluar()
    {
        $endpoint = "referensi/carakeluar";
        $caraKeluar = $this->bridging->getRequest($endpoint);
        return $caraKeluar;
    }

    public function pascaPulang()
    {
        $endpoint = "referensi/pascapulang";
        $pascaPulang = $this->bridging->getRequest($endpoint);
        return $pascaPulang;
    }

}