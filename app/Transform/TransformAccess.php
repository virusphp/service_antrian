<?php

namespace App\Transform;

class TransformAccess
{
    public function mapRegister($table)
    {
        $data["access"] = [
                'nama'       => $table->company,
                'email'      => $table->email,
                'username'   => $table->username,
                'created_at' => $table->created_at,
                'updated_at' => $table->updated_at,
        ];

        $data["api_token"] = $table->api_token;

        return $data;
    }

    public function mapLogin($table)
    {
        $data = [
            'company' => $table->company,
            'username' => $table->username,
            'email' => $table->email,
            'phone' => $table->phone,
            'token' => $table->api_token
        ];

        return $data;
    }

}