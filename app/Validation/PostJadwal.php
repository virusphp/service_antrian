<?php

namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class PostJadwal
{
    public function rules($request)
    {
        return Validator::make($request->all(),[
            'tanggalawal' => 'required|date',
            'tanggalakhir' => 'required|date',
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
            $error[] = $key. ' '.$value[0];
        }
        return $error;
        
    }
}