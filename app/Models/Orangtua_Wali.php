<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Orangtua_Wali extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'orangtua_wali';
    protected $primaryKey = 'id_orangtua_wali';
    public $incrementing = false;  // UUID, not auto-incrementing
    protected $keyType = 'string';  // UUID is a string

    protected $fillable = [
        'id_orangtua_wali',
        'nama_ayah',
        'NIK_ayah',
        'no_telp_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'nama_ibu',
        'NIK_ibu',
        'no_telp_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'nama_wali',
        'NIK_wali',
        'no_telp_wali',
        'pendidikan_wali',
        'pekerjaan_wali',
        'penghasilan_wali'
    ];

    public function pendidikanAyah()
    {
        return $this->belongsTo(Pendidikan_Terakhir::class, 'pendidikan_ayah', 'id_pendidikan_terakhir');
    }

    public function pendidikanIbu()
    {
        return $this->belongsTo(Pendidikan_Terakhir::class, 'pendidikan_ibu', 'id_pendidikan_terakhir');
    }

    public function pendidikanWali()
    {
        return $this->belongsTo(Pendidikan_Terakhir::class, 'pendidikan_wali', 'id_pendidikan_terakhir');
    }
}
