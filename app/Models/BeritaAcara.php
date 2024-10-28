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

    protected $fillable = ['tanggal', 'nidn', 'id_mata_kuliah', 'materi', 'jumlah_mahasiswa'];

    // Menggunakan boot untuk menghasilkan UUID secara otomatis
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            // Membuat UUID jika id_berita_acara kosong
            if (empty($model->id_berita_acara)) {
                $model->id_berita_acara = (string) Str::uuid();
            }
        });
    }

    /**
     * Relasi dengan model Dosen
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'nidn');
    }

    /**
     * Relasi dengan model Matakuliah
     */
    public function mataKuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'id_mata_kuliah', 'id_mata_kuliah');
    }
}
