<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan_Terakhir extends Model
{
    use HasFactory;
    protected $table = 'pendidikan_terakhir';
protected $fillable = [

    'nama_pendidikan_terakhir',
    'kode_pendidikan_terakhir',
];
}
