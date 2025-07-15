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
        $mulai = \Carbon\Carbon::parse($this->tanggal_mulai)->startOfDay();
        $selesai = \Carbon\Carbon::parse($this->tanggal_selesai)->endOfDay();
        // $now = \Carbon\Carbon::parse('2025-07-01');
        // return $now->between($mulai, $selesai);
        return now()->between($mulai, $selesai);
    }



    use HasFactory;
}
