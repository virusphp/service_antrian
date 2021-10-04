<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SuplierCollection extends ResourceCollection
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
            'suplier' => $this->collection->map(function($suplier) use ($request) {
                return (new SuplierResource($suplier))->toArray($request);
            })
        ];
    }
}
