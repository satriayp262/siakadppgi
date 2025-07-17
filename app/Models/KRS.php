<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KRS extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_krs';
    protected $table = 'krs';
    protected $fillable = [
        'NIM',
        'id_semester',
        'id_mata_kuliah',
        'id_kelas',
        'id_prodi', /// g perlu
        'group_praktikum'
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id_prodi');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester', 'id_semester');
    }

    public function matkul()
    {
        return $this->belongsTo(Matakuliah::class, 'id_mata_kuliah', 'id_mata_kuliah');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'NIM', 'NIM');
    }
    public function khs()
    {
        return $this->hasOne(KHS::class, 'id_krs', 'id_krs');
    }
    public function getKhsAttribute()
    {
        return $this->hasOne(KHS::class, 'id_krs', 'id_krs')->firstOrCreate([
            'id_krs' => $this->id_krs,
        ], [
            'bobot' => 0,
        ]);
    }

    public function jadwal()
    {
        return $this->hasOne(\App\Models\Jadwal::class, 'id_mata_kuliah', 'id_mata_kuliah')
            ->where(function ($query) {
                $query->whereColumn('jadwal.id_kelas', 'krs.id_kelas');
            });
    }
}
