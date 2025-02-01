<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semester';

    protected $primaryKey = 'id_semester';
    protected $fillable = [
        'nama_semester',
        'bulan_mulai',
        'bulan_selesai',

    ];
}
