<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GolonganObatCollection extends ResourceCollection
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
            'gol_obat' => $this->collection->map(function($subunit) use ($request) {
                return (new GolonganObatResource($subunit))->toArray($request);
            })
        ];
    }
}
