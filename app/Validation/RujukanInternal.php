<?php

namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class RujukanInternal
{
	public function rules($request)
    {
        return Validator::make($request->all(),[
            'tgl_reg' => 'required|min:6',
            'no_rujukan' => 'required|min:5',
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