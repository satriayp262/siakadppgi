<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonversiNilai extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_konversi_nilai';
    protected $table = 'konversi_nilai';
    protected $fillable = [
        'id_krs',
        'keterangan',
        'nilai',
        'file',
    ];

    public function krs()
    {
        return $this->belongsTo(KRS::class, 'id_krs');
    }
    public function getMahasiswaNamaAttribute()
    {
        return $this->krs->mahasiswa->nama ?? '-';
    }
    
}