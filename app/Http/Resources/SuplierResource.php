<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SuplierResource extends JsonResource
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
            'kode_suplier'    => trim($this->kdsuplier),
            'nama_suplier'  => trim($this->nmsuplier),
            'alamat' => $this->alamat,
            'telepon'  => $this->telpon
        ];
    }
}
