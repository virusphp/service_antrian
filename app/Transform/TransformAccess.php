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

}