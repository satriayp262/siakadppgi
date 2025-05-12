<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranTunai extends Model
{
    protected $table = 'pembayaran_tunai';
    protected $primaryKey = 'id_pembayaran';
    protected $fillable = [
        'id_pembayaran',
        'id_tagihan',
        'nominal',
        'tanggal_pembayaran',
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'id_tagihan', 'id_tagihan');
    }
}
