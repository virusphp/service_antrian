<?php

namespace App\Service\Bpjs;

use GuzzleHttp\Client;

class Bpjs 
{
    protected $client = null;
    protected $bpjs_url;
    protected $bpjs_url_sku;
    protected $header;

    public function __construct($consid, $timestamp, $signature)
    {
        $this->bpjs_url = config('bpjs.api.endpoint');
        $this->bpjs_url_sku = config('bpjs.api.endpointsku');
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