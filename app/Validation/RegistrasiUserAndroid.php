<?php

namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class RegistrasiUserAndroid
{
    public function rules($request)
    {
        return Validator::make($request->all(),[
            'no_rm' => 'required',
            'no_ktp' => 'required|min:10',
            'tanggal_lahir' => 'required|date',
            'email' => 'required|unique:user_pasien_online,email',
            'password' => 'required',
            'repassword' => 'required|same:password|min:6'
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