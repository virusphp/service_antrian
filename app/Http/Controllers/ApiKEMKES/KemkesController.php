<?php

namespace App\Http\Controllers\ApiKemkes;

use App\Http\Controllers\Controller;
use App\Helpers\KemkesHelper;

class KemkesController extends Controller
{
    protected $rsid;
    protected $passid;
    protected $timestamp;

	public function __construct()
	{
        $this->rsid = config('kemkes.api.rsid');
        $this->passid = config('kemkes.api.passid');
        $this->timestamp = KemkesHelper::timestamp();
	}
}