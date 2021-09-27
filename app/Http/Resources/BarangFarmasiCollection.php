<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BarangFarmasiCollection extends ResourceCollection
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
            'barang_farmasi' => [
                'data' =>  $this->collection->map(function($barangFarmasi) use ($request) {
                                return (new BarangFarmasiResource($barangFarmasi))->toArray($request);
                            }),
                'count' => $this->count(),
                'total' => $this->total(),
                'prev'  => $this->previousPageUrl(),
                'next'  => $this->nextPageUrl(),
            ]
        ];
    }
}
