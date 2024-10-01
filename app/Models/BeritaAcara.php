<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    use HasFactory;

    protected $table = 'berita_acara';
    protected $primaryKey = 'id_berita_acara';

    protected $fillable = ['tanggal', 'nidn', 'kode_mata_kuliah','materi', 'jumlah_mahasiswa'];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nidn');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kode_mata_kuliah');
    }
}
