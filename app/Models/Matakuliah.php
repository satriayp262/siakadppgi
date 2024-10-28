<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;
    protected $table = 'matkul';
    protected $primaryKey = 'id_mata_kuliah';
    protected $fillable = [
        'kode_mata_kuliah',
        'nama_mata_kuliah',
        'jenis_mata_kuliah',
        'nidn',
        'kode_prodi',   
        'sks_tatap_muka',
        'sks_praktek',
        'sks_praktek_lapangan',
        'sks_simulasi',
        'metode_pembelajaran',
        'tgl_mulai_efektif',
        'tgl_akhir_efektif',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'nidn');
    }

}
