<?php

namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class PostPasien
{
    public function rules($request)
    {
        return Validator::make($request->all(),[
            'no_rm' => 'required',
        ],[
            'required' => 'Tidak boleh kosong atau NULL!',
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