<?php

namespace App\Helpers;

class Waktu 
{
    public static function tanggalToNilai($tanggal)
    {
        return date("N", strtotime($tanggal)) + 1;
    }
}

