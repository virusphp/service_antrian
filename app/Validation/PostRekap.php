<?php

namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class PostRekap
{
    public function rules($request)
    {
        return Validator::make($request->all(),[
            'tanggalperiksa' => 'required|date',
            'kodepoli' => 'required',
            'polieksekutif' => 'required',
        ],[
            'required' => 'Tidak boleh kosong atau NULL!',
            'date'     => 'Tidak sesuai tanggal NASIONAL! atau Tidak Valid',
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