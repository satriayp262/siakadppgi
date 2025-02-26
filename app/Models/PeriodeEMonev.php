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
        'sesi',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester', 'id_semester');
    }


    use HasFactory;
}
