<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{

    use HasFactory;

    protected $table = 'jawaban';
    protected $primaryKey = 'id_jawaban';
    protected $fillable = ['id_pertanyaan', 'id_emonev', 'nilai'];

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'id_pertanyaan', 'id_pertanyaan');
    }

    public function emonev()
    {
        return $this->belongsTo(Emonev::class, 'id_emonev', 'id_emonev');
    }
}
