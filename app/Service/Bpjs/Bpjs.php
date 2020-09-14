<?php

namespace App\Service\Bpjs;

use GuzzleHttp\Client;

class Bpjs 
{
    protected $client = null;
    protected $bpjs_url;
    // protected $consid;
    // protected $timestamp;
    // protected $signature;
    protected $header;

    public function __construct($consid, $timestamp, $signature)
    {
        // $this->consid    = $consid;
        // $this->timestamp = $timestamp;
        // $this->signature = $signature;
        $this->bpjs_url = config('bpjs.api.endpoint');
        $this->client = new Client([
            'cookies' => true,
            'verify' => true
        ]);
        $this->header = [
            'X-cons-id'   => $consid, 
            'X-timestamp' => $timestamp, 
            'X-signature' => $signature
        ];
    }
}