<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    public $connection = 'sql_simrs';
    protected $table = "registrasi";

    protected $primaryKey = "no_reg";

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable  = [
        'no_reg',
        'no_rm',
        'tgl_reg',
        'waktu',
        'kd_asal_pasien',
        'status_pengunjung',
        'kd_cara_bayar',
        'jenis_pasien',
        'no_reg_pembayar',
        'kd_penjamin',
        'no_sjp',
        'user_id'
    ];
}
