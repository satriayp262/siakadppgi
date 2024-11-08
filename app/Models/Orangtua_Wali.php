<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Orangtua_Wali extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'orangtua_wali';
    protected $primaryKey = 'id_orangtua_wali';

    protected $fillable = [
        'id_orangtua_wali',
        'nama_ayah',
        'NIK_ayah',
        'tanggal_lahir_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'nama_ibu',
        'NIK_ibu',
        'tanggal_lahir_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'nama_wali',
        'NIK_wali',
        'tanggal_lahir_wali',
        'pendidikan_wali',
        'pekerjaan_wali',
        'penghasilan_wali'
    ];

    public function pendidikanAyah()
    {
        return $this->belongsTo(Pendidikan_Terakhir::class, 'pendidikan_ayah', 'kode_pendidikan_terakhir');
    }

    public function pendidikanIbu()
    {
        return $this->belongsTo(Pendidikan_Terakhir::class, 'pendidikan_ibu', 'kode_pendidikan_terakhir');
    }

    public function pendidikanWali()
    {
        return $this->belongsTo(Pendidikan_Terakhir::class, 'pendidikan_wali', 'kode_pendidikan_terakhir');
    }

    public function getPenghasilanOptions()
    {
        return [
            11 => 'Kurang dari Rp. 500,000',
            12 => 'Rp. 500,000 - Rp. 999,999',
            13 => 'Rp. 1,000,000 - Rp. 1,999,999',
            14 => 'Rp. 2,000,000 - Rp. 4,999,999',
            15 => 'Rp. 5,000,000 - Rp. 20,000,000',
            16 => 'Lebih dari Rp. 20,000,000',
        ];
    }

    public function getPekerjaanOptions()
    {
        return [
            1 => 'Tidak bekerja',
            2 => 'Nelayan',
            3 => 'Petani',
            4 => 'Peternak',
            5 => 'PNS/TNI/Polri',
            6 => 'Karyawan Swasta',
            7 => 'Pedagang Kecil',
            8 => 'Pedagang Besar',
            9 => 'Wiraswasta',
            10 => 'Wirausaha',
            11 => 'Buruh',
            12 => 'Pensiunan',
            13 => 'Peneliti',
            14 => 'Tim Ahli / Konsultan',
            15 => 'Magang',
            16 => 'Tenaga Pengajar / Instruktur / Fasilitator',
            17 => 'Pimpinan / Manajerial',
            98 => 'Sudah Meninggal',
            99 => 'Lainnya',
        ];
    }

    public function getPenghasilanAyahAttribute()
    {
        return $this->getPenghasilanOptions()[$this->attributes['penghasilan_ayah']] ?? 'Data Invalid';
    }

    public function getPenghasilanIbuAttribute()
    {
        return $this->getPenghasilanOptions()[$this->attributes['penghasilan_ibu']] ?? 'Data Invalid';
    }

    public function getPenghasilanWaliAttribute()
    {
        return $this->getPenghasilanOptions()[$this->attributes['penghasilan_wali']] ?? 'Data Invalid';
    }

    public function getPekerjaanAyahAttribute()
    {
        return $this->getPekerjaanOptions()[$this->attributes['pekerjaan_ayah']] ?? 'Data Invalid';
    }

    public function getPekerjaanIbuAttribute()
    {
        return $this->getPekerjaanOptions()[$this->attributes['pekerjaan_ibu']] ?? 'Data Invalid';
    }

    public function getPekerjaanWaliAttribute()
    {
        return $this->getPekerjaanOptions()[$this->attributes['pekerjaan_wali']] ?? 'Data Invalid';
    }

}
