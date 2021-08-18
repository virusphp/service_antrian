<?php

namespace App\Service\Bpjs;

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class Bridging extends Bpjs
{

    protected $headers;

    public function __construct($consid, $timestamp, $signature)
    {
        parent::__construct($consid, $timestamp, $signature);
        $urlencode = array('Content-Type' => 'Application/x-www-form-urlencoded');
        $this->headers = array_merge($this->header, $urlencode);
    }

    public function getRequest($endpoint)
    {
        try {
            $url = $this->bpjs_url . $endpoint;
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
            $url = $this->bpjs_url . $endpoint;
            // dd($url, $data, $this->headers);
            $result = $this->client->post($url, ['headers' => $this->headers, 'body' => $data]);
            return $result->getBody();
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
            $url = $this->bpjs_url . $endpoint;
            $result = $this->client->put($url, ['headers' => $this->headers, 'body' => $data]);
            return $result;
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
            $url = $this->bpjs_url . $endpoint;
            $result = $this->client->delete($url, ['headers' => $this->headers, 'body' => $data]);
            $response = $result->getBody();
            return $response;
        } catch (RequestException $e) {
            $result = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $result = Psr7\str($e->getResponse());
            }
        } 
    }
}