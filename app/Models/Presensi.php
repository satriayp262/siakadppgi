<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';
    protected $fillable = ['nama', 'nim', 'token', 'waktu_submit'];

    public function token()
    {
        return $this->belongsTo(Token::class, 'token', 'token');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function matkul()
    {
        return $this->hasOneThrough(Matakuliah::class, Token::class, 'token', 'id_mata_kuliah', 'token', 'id_mata_kuliah');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }
}
