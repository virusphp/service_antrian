<?php

namespace App\Transform;

use Illuminate\Pagination\LengthAwarePaginator;

class TransformBarang
{
    public function mapBarang($table)
    {
        foreach($table as $key => $value)
        {
            $data[$key] = [
                'idx_barang' => $value->idx_barang,
                'kode_barang' => $value->kd_barang,
                'nama_barang' => trim($value->nama_barang),
                'kode_jenis_obat' => $value->kd_jns_obat,
                'kode_satuan_besar' => $value->kd_satuan_kecil,
                'isi_satuan_besar' => $value->isi_satuan_besar,
                'harga_satuan_besar' => $value->harga_satuan_besar,
                'harga_satuan_netto' => $value->harga_satuan_netto,
                'harga_satuan' => $value->harga_satuan,
                'stok_min' => $value->stok_min,
                'dosis' => $value->dosis,
                'satuan_dosis' => $value->satdosis,
                'harga_jual' => $value->harga_jual,
                'diskon_persen' => $value->diskon_persen,
                'ppn1' => $value->ppn1,
                'ppn2' => $value->ppn2
            ];
        }

        $res["barang"] = $this->paginator($data);

        return $res;
    }

    protected function paginator($items, $perPage = 10)
    {
        //Get current page form url e.g. &page=6
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $current = Request()->input("page") ?? 1;
        $start_point = ($currentPage * $perPage) - $perPage;
        $array = array_slice($items, $start_point, $perPage, false);
    
        return new LengthAwarePaginator($array, count($items), $perPage, $current, [
            'path' => Request()->url(),
            'query' => Request()->query(),
        ]);
    }

}