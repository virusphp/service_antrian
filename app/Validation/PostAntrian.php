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
            'tanggalperiksa' => 'required',
            'kodepoli' => 'required',
            'nomorreferensi' => 'required',
            'jenisreferensi' => 'required',
            'jenisrequest' => 'required',
            'polieksekutif' => 'required',
        ]);
    }

    public function messages($errors)
    {
        $error = [];
        foreach($errors->getMessages() as $key => $value)
        {
                $error[$key] = $value[0];
        }
        return $error;
        
    }
}