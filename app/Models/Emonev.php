<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emonev extends Model
{
    use HasFactory;

    protected $table = 'emonev';
    protected $primaryKey = 'id_emonev';
    protected $fillable = ['nama_evaluasi', 'penilaian', 'saran', 'id_kelas', 'id_user'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
