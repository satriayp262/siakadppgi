<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeEMonev extends Model
{
    protected $table = 'periode_emonev';
    protected $primaryKey = 'id_periode';
    protected $fillable = [
        'id_semester',
        'nama_periode',
        'sesi',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester', 'id_semester');
    }

    // Di model PeriodeEMonev.php
    public function isAktif()
    {
        return now()->between($this->tanggal_mulai, $this->tanggal_selesai);
    }



    use HasFactory;
}
