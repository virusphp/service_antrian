<?php

namespace App\Transform;

class TransformOperasi
{
    public function mapOperasi($table)
    {
        foreach ($table as $value) {
            $data["list"][] = [
                    'kodebooking'    => $value->no_jadwal_ok,
                    'tanggaloperasi' => $value->tgl_tindakan,
                    'jenistindakan'  => $value->nama_jenis_tindakan_operasi,
                    'kodepoli'       => $value->kd_poli_dpjp,
                    'namapoli'       => $value->nama,
                    'terlaksana'     => $value->status_proses,
            ];
        }

        return $data;
    }

    public function mapJadwal($table)
    {
        foreach ($table as $value) {
            $data["list"][] = [
                    'kodebooking'    => $value->no_jadwal_ok,
                    'tanggaloperasi' => $value->tgl_tindakan,
                    'jenistindakan'  => $value->nama_jenis_tindakan_operasi,
                    'kodepoli'       => $value->kd_poli_dpjp,
                    'namapoli'       => $value->nama,
                    'terlaksana'     => (int)$value->status_proses,
                    'nopeserta'      => $value->no_kartu,
                    'lastupdate'     => time() * 1000
            ];
        }

        return $data;

    }


}