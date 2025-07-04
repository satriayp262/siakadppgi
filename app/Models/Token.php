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
        'id_mata_kuliah',
        'id_kelas',
        'id_semester',
        'valid_until',
        'pertemuan',
        'hari',
        'sesi',
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
        return $this->belongsTo(Matakuliah::class, 'id_mata_kuliah', 'id_mata_kuliah');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester', 'id_semester');
    }

    // Cek apakah token masih valid
    public function isValid()
    {
        return $this->valid_until >= now();
    }
}

