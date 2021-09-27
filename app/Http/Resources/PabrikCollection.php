<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PabrikCollection extends ResourceCollection
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
            'pabrik' => $this->collection->map(function($subunit) use ($request) {
                return (new PabrikResource($subunit))->toArray($request);
            })
        ];
    }
}
