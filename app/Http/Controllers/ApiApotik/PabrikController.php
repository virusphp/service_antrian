<?php

namespace App\Http\Controllers\ApiApotik;

use App\Http\Controllers\Controller;
use App\Http\Resources\PabrikCollection;
use App\Repository\Apotik\Pabrik;
use Illuminate\Http\Request;

class PabrikController extends Controller
{
    protected $pabrik;

    public function __construct()
    {
        $this->pabrik = new Pabrik;
    }

    public function getPabrik(Request $r)
    {
        $pabrik = $this->pabrik->getPabrik($r);
        $transform = new PabrikCollection($pabrik);
        return response()->jsonApi(200, 'OK', $transform);
    }
}