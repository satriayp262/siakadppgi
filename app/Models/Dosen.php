<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $primaryKey = 'id_dosen';

    protected $fillable = [
        'nama_dosen',
        'nidn',
        'jenis_kelamin',
        'jabatan_fungsional',
        'kepangkatan',
        'kode_prodi',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function tokens()
    {
        return $this->hasManyThrough(
            Token::class,
            User::class,
            'nim_nidn',
            'id',
            'nidn',
            'id'
        );
    }

}
