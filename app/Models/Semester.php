<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semester';
    protected $primaryKey = 'id_semester';
    protected $fillable = [
        'id_semester',
        'nama_semester'
    ];
    use HasFactory;
}
