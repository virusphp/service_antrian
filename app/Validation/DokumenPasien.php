<?php

namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class DokumenPasien
{
    public function rules($request)
    {
        return Validator::make($request->all(),[
            'no_rm' => 'required|min:6',
            'no_reg' => 'required|min:12',
            'kode_jenis_file' => 'required',
        ],[
            'required' => 'Tidak boleh kosong atau NULL!',
            'min'     => 'Tidak boleh kurang dari :min digit'
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