<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PabrikResource extends JsonResource
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
            'kode_pabrik'    => $this->kdpabrik,
            'nama_pabrik'  => $this->nmpabrik
        ];
    }
}
