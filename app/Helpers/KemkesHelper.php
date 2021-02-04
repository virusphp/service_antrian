<?php

namespace App\Helpers;
date_default_timezone_set('UTC');

class KemkesHelper
{

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
