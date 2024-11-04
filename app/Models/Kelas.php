<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';
    protected $fillable = [
        'kode_kelas',
        'semester',
        'nama_kelas',
        'kode_prodi',
        'lingkup_kelas',
        'kode_matkul',
        'id_mata_kuliah',
    ];
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester', 'id_semester');
    }

    public function matkul()
    {
        return $this->belongsTo(Matakuliah::class, 'id_mata_kuliah', 'id_mata_kuliah');
    }
}
