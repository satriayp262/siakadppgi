<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ttd extends Model
{
     protected $table = 'ttd';
    protected $primaryKey = 'id_ttd';
    protected $fillable = [
        'nama',
        'jabatan',
        'ttd',
        'tanggal_dibuat',
    ];
}
