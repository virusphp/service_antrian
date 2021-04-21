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

    public static function tglMaxRujukan($tglkunjungan, $tanggalperiksa)
    {
        $maxTglKunjungan = date("Y-m-d", strtotime("+90 days", strtotime($tglkunjungan)));

        if (strtotime($tanggalperiksa) > strtotime($maxTglKunjungan))
        {
            $res = 1;
        } else {
            $res = 0;
        }

        return $res;
    }

    public static function selisihTanggal($tanggalawal, $tanggalakhir)
    {
        if (strtotime($tanggalawal) > strtotime($tanggalakhir)) {
            // dd("masuk sini lebih besar");
            $res = 1;
        } else {
            // dd("benar");
            $res = 0;
        }

        return $res;
    }

    public static function tanggalInsert()
    {
        $date = date('Y-m-d H:i:s');
        return $date;
    }
}