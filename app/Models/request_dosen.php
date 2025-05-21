<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class request_dosen extends Model
{
    use HasFactory;

    protected $table = 'request_dosen';
    protected $primaryKey = 'id_request';
    protected $fillable = [
        'nidn',
        'id_mata_kuliah',
        'id_kelas',
        'hari',
        'sesi',
        'to_hari',
        'to_sesi',
        'status'
    ];

}
