<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JenisObatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'kode_jenis_obat'    => $this->kd_jns_obat,
            'jenis_obat'  => $this->jns_obat
        ];
    }
}
