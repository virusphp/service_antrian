<?php

namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class LoginUserAndroid
{
    public function rules($request)
    {
        return Validator::make($request->all(),[
            'username' => 'required|exists:sql_simrs.user_pasien_online,no_rm',
            'password' => 'required',
        ],[
            'required' => ':attribute tidak boleh kosong atau NULL!',
            'exists'   => ':attribute tersebut belum terdafatar! '
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