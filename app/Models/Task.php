<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $connection = 'sql_simrs';
    protected $table = "task_log";
    public $timestamps = true;

    protected $fillable = [
        'id',  'kodebooking', 'taskid', 'waktu', 'code',  'message', 'status'
    ];
}
