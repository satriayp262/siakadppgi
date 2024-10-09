<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';
    protected $fillable = [
        'id',
        'kode_mata_kuliah',
        'submitted_at',
    ];

    /**
     * Relasi ke model User (Mahasiswa)
     */
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'id');
    }

    /**
     * Relasi ke model Matkul
     */
    public function matkul()
    {
        return $this->belongsTo(Matakuliah::class);
    }
}
