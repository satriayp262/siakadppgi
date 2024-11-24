<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihan';
    protected $primaryKey = 'id_tagihan';
    protected $fillable = [
        'NIM',
        'total_tagihan',
        'status_tagihan',
        'id_semester',
        'Bulan',
        'total_bayar',
        'id_staff',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'NIM', 'NIM');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester', 'id_semester');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'id_staff', 'id_Staff');
    }



    use HasFactory;
}
