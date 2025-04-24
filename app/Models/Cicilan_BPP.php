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
        'id_transaksi',
        'id_konfirmasi',
        'metode_pembayaran',
        'id_semester',
        'jumlah_bayar',
        'tanggal_bayar',
        'cicilan_ke',
        'bulan',
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'id_tagihan', 'id_tagihan');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester', 'id_semester');
    }
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }
    public function konfirmasi()
    {
        return $this->belongsTo(Konfirmasi_Pembayaran::class, 'id_konfirmasi', 'id_konfirmasi');
    }
}
