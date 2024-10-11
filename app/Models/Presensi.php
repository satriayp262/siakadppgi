<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'nim', 'token_id', 'waktu_submit'];

    public function token()
    {
        return $this->belongsTo(Token::class);
    }
}
