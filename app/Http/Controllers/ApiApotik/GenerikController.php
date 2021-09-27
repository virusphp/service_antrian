<?php

namespace App\Http\Controllers\ApiApotik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GenerikController extends Controller
{

    public function getGenerik(Request $r)
    {
        $data['generik'] = [
            "G" => "G", 
            "N" => "N",
        ];

        if(!empty($r->term)) {
            $search = array_search($r->term, $data['generik']);
            if ($search) {
                $data['generik'] = [
                    "$search" => $search
                ];
            } else {
                $data['generik'] = [];
            }
        }
        $generik = $data;

        return response()->jsonApi(200, 'OK', $generik);
    }
}