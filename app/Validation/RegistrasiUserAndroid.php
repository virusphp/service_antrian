<?php

namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class RegistrasiUserAndroid
{
    public function rules($request)
    {
        return Validator::make($request->all(),[
            'no_rm' => 'required|min:6|unique:sql_simrs.user_pasien_online,no_rm',
            'no_ktp' => 'required|min:10',
            'tgl_lahir' => 'required|date',
            'email' => 'required|email|unique:sql_simrs.user_pasien_online,email',
            'password' => 'required',
            'repassword' => 'required|same:password|min:6'
        ],[
            'required' => ':attribute Tidak boleh kosong atau NULL!',
            'date'     => ':attribute Tidak sesuai tanggal NASIONAl! atau Tidak Valid',
            'email'       => 'Format Email :attribute tidak valid!!',
            'min'   => ':attribute kurang dari :min !!',
            'unique'   => ':attribute sudah terdaftar!!',
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