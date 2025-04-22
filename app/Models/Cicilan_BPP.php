<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cicilan_BPP extends Model
{
    use HasFactory;
    protected $table = 'cicilan_bpp';
    protected $primaryKey = 'id_cicilan';
    protected $fillable = [
        'id_tagihan',
        'order_id',
        'id_semester',
        'bulan_cicilan',
        'cicilan_ke'
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'id_tagihan', 'id_tagihan');
    }
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'order_id', 'order_id');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester', 'id_semester');
    }
}
