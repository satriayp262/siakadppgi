<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';
    protected $fillable = [
        'id_kelas', 'nidn', 'id_mata_kuliah', 'kode_prodi', 'id_semester', 'tanggal', 'jenis_ujian', 'id_ruangan', 'hari', 'sesi', 'jam_mulai', 'jam_selesai'
    ];


    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'nidn');
    }
    
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'id_mata_kuliah', 'id_mata_kuliah');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester');
    }
}
