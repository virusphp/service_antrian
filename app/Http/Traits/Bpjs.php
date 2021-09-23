<?php

namespace App\Http\Traits;

use App\Generator\GeneratorBpjs;

trait Bpjs 
{
	public function setConsid()
	{
		return config('bpjs.api.consid');
	}

	public function setSeckey()
	{
        return config('bpjs.api.seckey');
	}

	public function setServiceApi()
	{
		return config('bpjs.api.endpoint');
	}

	public function setTimestamp()
	{
        return GeneratorBpjs::bpjsTimestamp();
	}

	public function setSignature()
	{
        return GeneratorBpjs::generateSignature($this->setConsid(),$this->setSeckey());
	}

	public function setKey()
	{
        return GeneratorBpjs::keyString($this->setConsid(), $this->setSeckey());
	}

	public function setUrlEncode()
	{
		return array('Content-Type' => 'Application/x-www-form-urlencoded');
	}

	public function setHeader()
	{
		return [
			'X-cons-id'   => $this->setConsid(),
			'X-timestamp' => $this->setTimestamp(),
			'X-signature' => $this->setSignature()
		];
	}

	public function setHeaders()
	{
		return array_merge($this->setHeader(), $this->setUrlEncode());
	}
}