<?php

namespace App\Service\Bpjs;

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class Bridging extends Bpjs
{
    public function __construct($consid, $timestamp, $signature)
    {
        parent::__construct($consid, $timestamp, $signature);
    }

    public function getRequest($endpoint)
    {
        try {
            $url = $this->bpjs_url . $endpoint;
            $response = $this->client->get($url, ['headers' => $this->header]);
            $result = $response->getBody();
            return $result;
        } catch (RequestException $e) {
            $result = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $result = Psr7\str($e->getResponse());
            }
        } 
    }
}