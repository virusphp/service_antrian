<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
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
            'bagian' => [
                'kode_bagian'    => $this->kdbagian,
                'nama_bagian'  => $this->nmbagian
            ]
        ];
    }
}
