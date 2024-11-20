<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktifitas extends Model
{
    use HasFactory;
    protected $table = 'aktifitas';
    protected $primaryKey = 'id_aktifitas';

    protected $fillable = [
        'nama_aktifitas',
        'id_kelas',
        'catatan',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }
}
