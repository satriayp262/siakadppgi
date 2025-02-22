<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatSP extends Model
{
    use HasFactory;
    protected $table = 'riwayat_sp';
    protected $fillable = ['nim', 'sent_at'];
}
