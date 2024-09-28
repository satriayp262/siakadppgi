<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $primaryKey = 'kode_kelas';
    protected $fillable = [
        'kode_kelas',
        'nama_kelas',
        'kode_prodi',
        'lingkup_kelas',
        'kode_matkul',
    ];
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
    public function matkul()
    {
        return $this->belongsTo(Matakuliah::class);
    }
}
