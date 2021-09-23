<?php

namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class PostAntrianV2
{
    public function rules($request)
    {
       
        return Validator::make($request->all(),[
            'nomorkartu' => 'required',
            'nik' => 'required',
            'nohp' => 'required',
            'kodepoli' => 'required',
            'norm' => 'required',
            'tanggalperiksa' => 'required|date',
            'kodedokter' => 'required',
            'jampraktek' => 'required',
            'jeniskunjungan' => 'required|in:1,2,3',
            'nomorreferensi' => 'required',
        ],[
            'required' => 'Tidak boleh kosong atau NULL!',
            'date'     => 'Tidak sesuai tanggal NASIONAl! atau Tidak Valid',
            'in'       => 'Tidak sesuai!!',
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