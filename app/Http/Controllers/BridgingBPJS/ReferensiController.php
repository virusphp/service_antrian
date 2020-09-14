<?php

namespace App\Http\Controllers\BridgingBPJS;

use App\Service\Bpjs\Referensi;

class ReferensiController extends BpjsController
{
    protected $ref;

    public function __construct()
    {
        parent::__construct();
        $this->ref = new Referensi($this->consid, $this->timestamp, $this->signature);
    }

    public function diagnosa($kode)
    {
        $endpoint = "referensi/diagnosa/". $kode;
        $diagnosa = $this->ref->referensi($endpoint);
        return $diagnosa;
    }

    public function poli($kode)
    {
        $endpoint = "referensi/poli/" . $kode;
        $poli = $this->ref->referensi($endpoint);
        return $poli;
    }

    public function faskes($kodeNama, $jenisFaskes)
    {
        $endpoint = "referensi/faskes/" . $kodeNama . "/" . $jenisFaskes;
        $faskes = $this->ref->referensi($endpoint);
        return $faskes;
    }

    public function dpjp($jnsPel, $tglPel, $subSpesial)
    {
        $endpoint = "referensi/dokter/pelayanan/" . $jnsPel . "/tglPelayanan/" . $tglPel. "/Spesialis/". $subSpesial;
        $dpjp = $this->ref->referensi($endpoint);
        return $dpjp;
    }

    public function propinsi()
    {
        $endpoint = "referensi/propinsi";
        $propinsi = $this->ref->referensi($endpoint);
        return $propinsi;
    }

    public function kabupaten($kodePropinsi)
    {
        $endpoint = "referensi/kabupaten/propinsi/" . $kodePropinsi;
        $kabupaten = $this->ref->referensi($endpoint);
        return $kabupaten;
    }

}