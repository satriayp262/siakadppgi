<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;





class Mahasiswa extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_mahasiswa';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'mahasiswa';
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }
    protected $fillable = [
        'id_mahasiswa',
        'id_orangtua_wali',
        'NIM',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'NIK',
        'agama',
        'alamat',
        'jalur_pendaftaran',
        'kewarganegaraan',
        'jenis_pendaftaran',
        'tanggal_masuk_kuliah',
        'mulai_semester',
        'jenis_tempat_tinggal',
        'telp_rumah',
        'no_hp',
        'email',
        'terima_kps',
        'no_kps',
        'jenis_transportasi',
        'kode_prodi',
        'SKS_diakui',
        'kode_pt_asal',
        'nama_pt_asal',
        'kode_prodi_asal',
        'nama_prodi_asal',
        'jenis_pembiayaan',
        'jumlah_biaya_masuk',
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function prodi() 
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function semester() 
    {
        return $this->belongsTo(Semester::class, 'mulai_semester', 'id_semester');
    }
}
