<?php

namespace App\Helpers;
//default time zone
class Waktu 
{
    public static function tanggalToNilai($tanggal)
    {
        return date("N", strtotime($tanggal)) + 1;
    }

    //fungsi check tanggal merah
    public static function tanggalMerah($tanggal)
    {
        $array = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json"),true);

        //check tanggal merah berdasarkan libur nasional
        $tanggal = date('Ymd', strtotime($tanggal));
        if(isset($array[$tanggal])) : return "Tanggal merah ".$array[$tanggal]["deskripsi"];

        //check tanggal merah berdasarkan hari minggu
        elseif(date("D",strtotime($tanggal))==="Sun"): return "Tanggal merah hari minggu";

        elseif(strtotime($tanggal) < strtotime(date('Y-m-d'))): return "Tanggal tidak boleh kurang dari hari ini!";

        //bukan tanggal merah
        else : return false ; endif;
    }
}