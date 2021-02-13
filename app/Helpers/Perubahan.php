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

    public static function tanggalIndo($nilai)
    {
        return date('d-m-Y', strtotime($nilai));
    }

    public static function jenis_rawat($nilai)
    {
        $hasil = substr($nilai,0,2);
        if($hasil=='01'){
            return "RJ";
        }else if($hasil=='02'){
            return "RI";
        }else if($hasil=='03'){
           return "RD";
        }else{
            return "LB";
        }
    }

    public static function ribuan($nilai)
    {
        return number_format($nilai, "2",",",".");
    }

    function array_group($key, $data) {
        $result = array();
    
        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }
    
        return $result;
    }

    public static function round_up($value, $places) {
        $mult = 100;
        return $places < 0 ?
            ceil($value / $mult) * $mult :
            ceil($value * $mult) / $mult;
    }
}