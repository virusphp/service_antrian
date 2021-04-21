<?php

namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class RegistrasiPlatform
{
    public function rules($request)
    {
        return Validator::make($request->all(),[
            'name' => 'required',
            'username' => 'required|min:5|unique:access_platform,username',
            'email' => 'required|min:5|unique:access_platform,email',
            'password' => 'required',
            'repassword' => 'required|same:password|min:6',
            'phone' => 'required|min:10',
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