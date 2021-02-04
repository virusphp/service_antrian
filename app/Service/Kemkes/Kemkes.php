<?php

namespace App\Service\Kemkes;

use GuzzleHttp\Client;

class Kemkes 
{
    protected $client = null;
    protected $kemkes_url;
    protected $header;

    public function __construct($rsid, $passid, $timestamp)
    {
        $this->kemkes_url = config('kemkes.api.endpoint');
        $this->client = new Client([
            'cookies' => true,
            'verify' => true
        ]);
        $this->header = [
            'X-rs-id'   => $rsid, 
            'X-Timestamp' => $timestamp, 
            'X-pass' => $passid
        ];
    }
}