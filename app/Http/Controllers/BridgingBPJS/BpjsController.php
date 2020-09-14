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

	public function __construct()
	{
        $this->consid = config('bpjs.api.consid');
        $this->seckey = config('bpjs.api.seckey');
        $this->timestamp = BPJSHelper::timestamp();
        $this->signature = BPJSHelper::signature($this->consid,$this->seckey);
	}
}