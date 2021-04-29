<?php

namespace App\Transform;

class TransformPoliklinik
{
    public function mapListKarcis($table)
    {
        $data["poliklinik"] = $table;

        return $data;
    }

}