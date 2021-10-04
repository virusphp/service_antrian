<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UnitCollection extends ResourceCollection
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
            'unit' => $this->collection->map(function($suplier) use ($request) {
                return (new UnitResource($suplier))->toArray($request);
            })
        ];
    }
}
