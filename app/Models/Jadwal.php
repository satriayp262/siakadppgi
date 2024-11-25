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
        'id_kelas', 'tanggal', 'id_ruangan', 'hari', 'sesi', 'jam_mulai', 'jam_selesai'
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nidn');
    }

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'kode_mata_kuliah');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }
}
