<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emonev extends Model
{
    use HasFactory;

    protected $table = 'emonev';
    protected $primaryKey = 'id_emonev';
    protected $fillable = ['id_semester', 'nidn', 'id_mata_kuliah', 'saran', 'id_kelas'];

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester', 'id_semester');
    }


    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'nidn');
    }

    public function matkul()
    {
        return $this->belongsTo(Matakuliah::class, 'id_mata_kuliah', 'id_mata_kuliah');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'id_emonev', 'id_emonev');
    }
}
