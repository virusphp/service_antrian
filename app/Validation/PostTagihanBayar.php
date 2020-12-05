<?php

namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class PostTagihanBayar
{
    public function rules($request)
    {
        // dd($request);
        return Validator::make($request->all(),[
            'no_rm' => 'required', 
            'nama_pembayar' => 'required', 
            'alamat_pembayar' => 'required',
            'tanggal_registrasi' => 'required|date', 
            // 'pasien.nama_pasien' => 'required', 
            // 'pasien.alamat_pasien' => 'required', 
            
            // 'pasien.tanggal_registrasi' => 'required', 
            // 'pasien.tanggal_lahir_pasien' => 'required', 
            // 'pasien.jenis_kelamin_pasien' => 'required', 
            // 'pasien.usia_pasien' => 'required',
            // 'tagihan.*.no_reg' => 'required',
            // 'tagihan.*.jenis_rawat' => 'required', 
            // 'tagihan.*.kelompok_tagihan' => 'required',
            // 'tagihan.*.kelompok' => 'required',
            // 'tagihan.*.total_tagihan' => 'required',
            // 'tagihan.*.rincian_tagihan.*.no_tagihan' => 'required',
            // 'tagihan.*.rincian_tagihan.*.no_bukti' => 'required',
            // 'tagihan.*.rincian_tagihan.*.jumlah' => 'required',
            // 'tagihan.*.rincian_tagihan.*.nama_tarif' => 'required',
            // 'tagihan.*.rincian_tagihan.*.biaya' => 'required',
            // 'tagihan.*.rincian_tagihan.*.kd_dokter' => 'required',
            // 'tagihan.*.rincian_tagihan.*.kd_subunit' => 'required', 
            // 'tagihan.*.rincian_tagihan.*.akun_rek1' => 'required', 
        ],[
            'required' => 'Tidak boleh kosong',
        ]);
    }

    public function messages($errors)
    {
        $error = [];
        foreach($errors->getMessages() as $key => $value)
        {
            $error[] = $key. ' '.$value[0];
        }
        return $error;
    }
}