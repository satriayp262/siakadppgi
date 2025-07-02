<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'presensi';
    protected $fillable = ['nama', 'nim', 'token', 'waktu_submit', 'keterangan', 'alasan', 'id_kelas', 'id_mata_kuliah'];

    public function tokenlist()
    {
        return $this->belongsTo(Token::class, 'token', 'token');
    }
    public function token()
    {
        return $this->belongsTo(Token::class, 'token', 'token');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'NIM');
    }

    public function matkul()
    {
        return $this->hasOneThrough(Matakuliah::class, Token::class, 'token', 'id_mata_kuliah', 'token', 'id_mata_kuliah');
    }
    public function kelas()
    {
        return $this->hasOneThrough(Matakuliah::class, Token::class, 'token', 'id_kelas', 'token', 'id_kelas');
    }
}
