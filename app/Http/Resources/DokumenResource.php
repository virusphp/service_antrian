<?php

namespace App\Http\Resources;

use App\Http\Traits\ImageTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class DokumenResource extends JsonResource
{
    use ImageTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $file = $this->getBio($this->no_rm, $this->file_pasien);
        
        return [
                'id_file'         => $this->id_file,
                'no_rm'           => $this->no_rm,
                'no_reg'          => $this->no_reg,
                'kode_jenis_file' => $this->kd_jenis_file,
                'nama_file'       => $this->file_pasien,
                'path_file'       => $file,
                'tanggal_created' => $this->tgl_created,
                'user_created'    => $this->nama_pegawai
        ];
    }
}
