<?php

namespace App\Service\Kemkes;

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class Bridging extends Kemkes
{

    protected $headers;

    public function __construct($rsid, $passid, $timestamp)
    {
        parent::__construct($rsid, $passid, $timestamp);
        $urlencode = array('Content-Type' => 'Application/x-www-form-urlencoded');
        $this->headers = array_merge($this->header, $urlencode);
    }

    public function getRequest($endpoint)
    {
        try {
            $url = $this->kemkes_url . $endpoint;
            // dd($url);
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
            $url = $this->kemkes_url . $endpoint;
            $response = $this->client->post($url, ['headers' => $this->headers, 'body' => $data]);
            $result = $response->getBody();
            return $result;
        } catch (RequestException $e) {
            $result = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $result = Psr7\str($e->getResponse());
            }
        } 
    }

    public function postReqeustPassword($endpoint, $data)
    {
        $data = file_get_contents("php://input");
        try {
            $url = $this->kemkes_url . $endpoint;
            $response = $this->client->post($url, ['headers' => $this->header, 'body' => $data]);
            $result = $response->getBody()->getContents();
            return $result;
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
            $url = $this->kemkes_url . $endpoint;
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
        try {
            $url = $this->kemkes_url . $endpoint;
            $result = $this->client->delete($url, ['headers' => $this->headers, 'body' => $data]);
            $response = $result->getBody()->getContents();
            return $response;
        } catch (RequestException $e) {
            $result = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $result = Psr7\str($e->getResponse());
            }
        } 
    }
}