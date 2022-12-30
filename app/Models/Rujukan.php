<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rujukan extends Model
{
    public $connection = 'sql_simrs';
    protected $table = "rujukan";

    protected $primaryKey = "no_reg";

    protected $keyType = "string";

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'no_rujukan',
        'no_reg',
        'no_rm',
        'tgl_rujukan',
        'kd_instansi',
        'nama_pengirim',
        'kd_icd',
        'kd_smf',
        'diagnosa_sementara'
    ];
}
