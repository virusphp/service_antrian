<?php

namespace App\Helpers;

class BPJSHelper
{
    public static function signature($cusid, $secid)
    {
        $timestamps = strval(time()-strtotime('1970-01-01 00:00:00'));
        $ensig = hash_hmac('sha256', $cusid."&".$timestamps, $secid, true);
        $signature = base64_encode($ensig);
        return $signature;
    }

    public static function timestamp()
    {
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        return $timestamp;
    }

    public static function enkripsi($passid)
    {
        return MD5($passid);
    }

}
