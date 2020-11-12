<?php

namespace App\Helpers;

use DateTime;

class Perubahan
{
    public static function jenisKelamin($nilai)
    {
        return $nilai == 1 ? "Laki-laki" : "Perempuan";
    }

    public static function usia($nilai)
    {
        $tanggal_lalhir = new DateTime($nilai);
        $today = new DateTime('today');
        return $today->diff($tanggal_lalhir)->y;
    }

    public static function tanggalSekarang($nilai)
    {
        return date('Y-m-d', strtotime($nilai));
    }
}