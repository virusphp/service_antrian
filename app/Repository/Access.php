<?php

namespace App\Repository;

use DB;
use Carbon\Carbon;
use Exception;
use App\Helpers\BPJSHelper;
use Illuminate\Support\Facades\Hash;

class Access
{
    public function save($params)
    {
        try {
            $access = DB::table('access_platform')->insert([
                'company' => $params->name,
                'username' => $params->username,
                'email' => $params->email,
                'password' => Hash::make($params->password),
                'phone' => $params->phone,
                'api_token' => BPJSHelper::signature($params->username, $params->password),
                'created_at' => Carbon::now(),
            ]);

            if (!$access) {
                return response()->jsonApi(500, "Error Transaction", "Error proses insert data!");
            }

            $access = DB::table('access_platform')
                        ->select('company', 'username','email','api_token','created_at','updated_at')
                        ->where('username', $params->username)
                        ->first();

            return $access;
            
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }
}