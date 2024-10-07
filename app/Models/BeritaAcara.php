<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BeritaAcara extends Model
{
    use HasFactory;

    protected $table = 'berita_acara';
    protected $primaryKey = 'id_berita_acara';
    public $incrementing = false; // Karena UUID tidak auto-increment
    protected $keyType = 'string'; // Tipe data UUID

    protected $fillable = ['tanggal', 'nidn', 'kode_mata_kuliah', 'materi', 'jumlah_mahasiswa'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id_berita_acara)) {
                $model->id_berita_acara = (string) Str::uuid();
            }
        });
    }

    // Dalam model BeritaAcara
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'nidn');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'kode_mata_kuliah', 'kode_mata_kuliah');
    }
}
