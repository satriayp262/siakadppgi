<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konfirmasi_Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'konfirmasi';
    protected $primaryKey = 'id_konfirmasi';
    protected $fillable = [
        'id_tagihan',
        'bukti_pembayaran',
        'bulan',
        'jumlah_pembayaran',
        'tanggal_pembayaran',
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'id_tagihan', 'id_tagihan');
    }
}
