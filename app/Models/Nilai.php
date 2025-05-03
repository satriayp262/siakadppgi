<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_nilai';
    protected $table = 'nilai';
    protected $fillable = [
        'id_aktifitas',
        'NIM',
        'id_kelas',// g perlu
        'nilai',
    ];

    public function aktifitas()
    {
        return $this->belongsTo(Aktifitas::class, 'id_aktifitas', 'id_aktifitas');
    }
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'NIM', 'NIM');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class,  'id_kelas', 'id_kelas');
    }
}
