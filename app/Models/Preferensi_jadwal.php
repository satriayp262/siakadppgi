<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preferensi_jadwal extends Model
{
    use HasFactory;
    protected $table = 'preferensi_jadwal_dosen';
    protected $primaryKey = 'id_preferensi';
    protected $fillable = [
        'nidn',
        'hari',
        'waktu'
    ];
}
