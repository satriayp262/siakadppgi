<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class komponen_kartu_ujian extends Model
{
    use HasFactory;
    protected $table = 'komponen_kartu_ujian';
    protected $primaryKey = 'id_komponen';
    protected $fillable = [
        'nama',
        'jabatan',
        'ttd',
        'tanggal_dibuat',
    ];

}
