<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;
    protected $table = 'kurikulum';
    protected $primaryKey = 'id_kurikulum';
    protected $fillable = [
        'nama_kurikulum',
        'mulai_berlaku',
        'jumlah_sks_lulus',
        'jumlah_sks_wajib',
        'jumlah_sks_pilihan',
        'kode_prodi'
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'mulai_berlaku', 'id_semester');
    }
}
