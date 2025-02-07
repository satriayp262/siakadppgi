<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktifitas extends Model
{
    use HasFactory;
    protected $table = 'aktifitas';
    protected $primaryKey = 'id_aktifitas';

    protected $fillable = [
        'nama_aktifitas',
        'id_mata_kuliah',
        'id_kelas',
        'catatan',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }
    public function matkul()
    {
        return $this->belongsTo(Matakuliah::class, 'id_mata_kuliah', 'id_mata_kuliah');
    }
    public function createLainnya($id_mata_kuliah)
{
    // Get all classes
    $kelas = Kelas::all();

    foreach ($kelas as $kelasItem) {
        // Check if 'Lainnya' exists for the current id_kelas
        $exists = self::where('id_kelas', $kelasItem->id_kelas)
            ->where('id_mata_kuliah', $id_mata_kuliah)
            ->where('nama_aktifitas', 'Lainnya')
            ->exists();

        // If 'Lainnya' does not exist, create it
        if (!$exists) {
            self::create([
                'id_kelas' => $kelasItem->id_kelas,
                'id_mata_kuliah' => $id_mata_kuliah,
                'nama_aktifitas' => 'Lainnya',
                'catatan' => 'Digunakan hanya jika bobot Lainnya lebih dari 0',
            ]);
        }
    }
}

}
