<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SatuanCollection extends ResourceCollection
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
            'satuan' => $this->collection->map(function($subunit) use ($request) {
                return (new SatuanResource($subunit))->toArray($request);
            })
        ];
    }
}
