<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    protected $table = 'prodi';
    protected $primaryKey = 'id_prodi';
    protected $fillable = [
        'kode_prodi',
        'nama_prodi',
        'jenjang',
    ];

    public function matakuliah()
    {
        return $this->hasMany(Matakuliah::class, 'kode_prodi', 'kode_prodi');
    }
}
