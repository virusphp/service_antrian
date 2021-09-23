<?php

namespace App\Service\Bpjs;

use App\Generator\GeneratorBpjs;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\Http\Traits\Bpjs;
use GuzzleHttp\Client;

class Bridging
{
    use Bpjs;

    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => true,
            'cookie' => true
        ]);
    }

    public function getRequest($endpoint)
    {
        try {
            $url = $this->setServiceApi() . $endpoint;
            $response = $this->client->get($url, ['headers' => $this->setHeader()]);
            $result = GeneratorBpjs::responseBpjsV2($response->getBody()->getContents(), $this->setKey());
            return $result;
        } catch (RequestException $e) {
            $result = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $result = Psr7\str($e->getResponse());
            }
        } 
    }

    public function getRequestSku($endpoint)
    {
        try {
            $url = $this->bpjs_url_sku . $endpoint;
            $response = $this->client->get($url, ['headers' => $this->header]);
            $result = $response->getBody()->getContents();
            return $result;
        } catch (RequestException $e) {
            $result = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $result = Psr7\str($e->getResponse());
            }
        } 
    }

    public function postRequest($endpoint, $data)
    {
        $data = file_get_contents("php://input");
        try {
            $url = $this->setServiceApi() . $endpoint;
            $response = $this->client->post($url, ['headers' => $this->setHeaders(), 'body' => $data]);
			$result = GenerateBpjs::responseBpjsV2($response->getBody(), $this->key);
            return $result();
        } catch (RequestException $e) {
            $result = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $result = Psr7\str($e->getResponse());
            }
        } 
    }

    public function putRequest($endpoint, $data)
    {
        $data = file_get_contents("php://input");
        try {
            $url = $this->setServiceApi() . $endpoint;
            $response = $this->client->post($url, ['headers' => $this->setHeaders(), 'body' => $data]);
			$result = GenerateBpjs::responseBpjsV2($response->getBody(), $this->key);
            return $result();
        } catch (RequestException $e) {
            $result = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $result = Psr7\str($e->getResponse());
            }
        } 
    }

    public function deleteRequest($endpoint, $data)
    {
        $data = file_get_contents("php://input");
        // dd($data, $this->header, $endpoint);
        try {
            $url = $this->setServiceApi() . $endpoint;
            $response = $this->client->post($url, ['headers' => $this->setHeaders(), 'body' => $data]);
			$result = GenerateBpjs::responseBpjsV2($response->getBody(), $this->key);
            return $result();
        } catch (RequestException $e) {
            $result = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $result = Psr7\str($e->getResponse());
            }
        } 
    }
}