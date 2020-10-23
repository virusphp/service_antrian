<?php

namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class PostAntrian
{
    public function rules($request)
    {
       
        return Validator::make($request->all(),[
            'nomorkartu' => 'required',
            'nik' => 'required',
            'notelp' => 'required',
            'tanggalperiksa' => 'date',
            'kodepoli' => 'required',
            'nomorreferensi' => 'required',
            'jenisreferensi' => 'required|in:1,2',
            'jenisrequest' => 'required|in:1,2',
            'polieksekutif' => 'required',
        ],[
            'required' => 'Tidak boleh kosong / Null!',
            'date'     => 'Tidak sesuai tanggal nasional! / Tidak Valid',
            'in'       => 'Tidak sesuai!!'
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