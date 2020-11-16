<?php

namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class PostTagihanBayar
{
    public function rules($request)
    {
        return Validator::make($request->all(),[
            'no_rm' => 'required', 
            'no_reg' => 'required',
            'jenis_rawat' => 'required'         
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