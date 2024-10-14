<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $table = 'token';
    protected $fillable = [
        'token',
        'kode_mata_kuliah',
        'valid_until',
        'id',
    ];

    // Relasi ke dosen (user)
    public function dosen()
    {
        return $this->belongsTo(User::class, 'id');
    }

    // Relasi ke mata kuliah
    public function matkul()
    {
        return $this->belongsTo(Matakuliah::class, 'kode_mata_kuliah', 'kode_mata_kuliah');
    }

    // Cek apakah token masih valid
    public function isValid()
    {
        return $this->valid_until >= now();
    }
}

