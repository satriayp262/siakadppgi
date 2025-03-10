<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paketKRS extends Model
{
    use HasFactory;

    protected $table = 'paket_krs';
    protected $primaryKey = 'id_paket_krs';

    protected $fillable = [
        'id_semester',
        'id_prodi',
        'id_mata_kuliah',
        'id_kelas',
        'tanggal_mulai',
        'tanggal_selesai',
    ];


    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id_prodi');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester', 'id_semester');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }
    public function matkul()
    {
        return $this->belongsTo(Matakuliah::class, 'id_mata_kuliah', 'id_mata_kuliah');
    }
}
