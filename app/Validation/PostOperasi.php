<?php

namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class PostOperasi
{
    public function rules($request)
    {
        return Validator::make($request->all(),[
            'nopeserta' => 'required',
        ],[
            'required' => 'Tidak boleh kosong'
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