<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SepBpjs extends Model
{
    public $connection = 'sql_simrs';
    protected $table = "sep_bpjs";
    protected $primaryKey = "no_reg";

    public $timestamps = false;

    protected $fillable = [
        'no_reg',
        'no_sjp',
        'cob',
        'kd_faskes',
        'nama_faskes',
        'kd_diagnosa',
        'nama_diagnosa',
        'kd_poli',
        'nama_poli',
        'kd_kelas_rawat',
        'nama_kelas_rawat',
        'no_rujukan',
        'asal_faskes',
        'tgl_rujukan',
        'lakalantas',
        'no_surat_kontrol',
        'kd_dpjp',
        'tujuan_kunjungan',
        'flag_prosedur',
        'kode_penunjang',
        'assesment_pelayanan',
        'dpjp_pelayanan',
        'catatan',
        'tgl_sep'
    ];
}
