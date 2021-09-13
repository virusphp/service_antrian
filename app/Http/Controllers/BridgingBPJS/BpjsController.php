<?php

namespace App\Http\Controllers\BridgingBPJS;

use App\Http\Controllers\Controller;
use App\Helpers\BPJSHelper;

class BpjsController extends Controller
{
    protected $consid;
    protected $seckey;
    protected $timestamp;
    protected $signature;
    protected $key;

	public function __construct()
	{
        $this->consid = config('bpjs.api.consid');
        $this->seckey = config('bpjs.api.seckey');
        $this->timestamp = BPJSHelper::timestamp();
        $this->signature = BPJSHelper::signature($this->consid,$this->seckey);
        $this->key = BPJSHelper::keyString($this->consid, $this->seckey);
	}

    protected function responseBpjs($dataJson)
    {
        if ($dataJson->metaData->code == "200") {
            // dd(BPJSHelper::stringEncrtypt($this->key, json_encode($dataJson->metaData)));
            return $this->decomporessed($dataJson->metaData, $dataJson->response);
        }
        return json_encode($dataJson);
    }

    protected function decomporessed($metadata, $response)
    {
        // return BPJSHelper::stringDecrypt($this->key, $response);
        return [
            $metadata,
            json_decode(BPJSHelper::decompress(BPJSHelper::stringDecrypt($this->key, $response)), true)
        ];
    }
}