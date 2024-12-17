<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KHS extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_khs';
    protected $table = 'khs';
    protected $fillable = [
        'id_khs',
        'NIM',
        'id_semester',
        'id_mata_kuliah',
        'id_kelas',
        'id_prodi',
        'bobot',
        'publish',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id_prodi');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester', 'id_semester');
    }

    public function matkul()
    {
        return $this->belongsTo(Matakuliah::class, 'id_mata_kuliah', 'id_mata_kuliah');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'NIM', 'NIM');
    }
    public static function calculateBobot($id_kelas, $NIM)
    {
        $kelas = Kelas::find($id_kelas);
        if (!$kelas) {
            throw new \Exception('Kelas not found for the given KHS.');
        }

        $bobotTugas = $kelas->tugas ?? 0;
        $bobotUTS = $kelas->uts ?? 0;
        $bobotUAS = $kelas->uas ?? 0;
        $bobotLainnya = $kelas->lainnya ?? 0;

        $totalWeight = $bobotTugas + $bobotUTS + $bobotUAS + $bobotLainnya;

        if ($totalWeight != 100) {
            $bobotTugas = ($bobotTugas / $totalWeight) * 100;
            $bobotUTS = ($bobotUTS / $totalWeight) * 100;
            $bobotUAS = ($bobotUAS / $totalWeight) * 100;
            $bobotLainnya = ($bobotLainnya / $totalWeight) * 100;
        }

        $totalBobot = 0;

        $nilaiUTS = Nilai::where('NIM', $NIM)
            ->where('id_kelas', $kelas->id_kelas)
            ->whereHas('aktifitas', fn($query) => $query->where('nama_aktifitas', 'UTS'))
            ->first();

        if ($nilaiUTS) {
            $totalBobot += ($nilaiUTS->nilai / 100) * 4.00 * ($bobotUTS / 100);
        }

        $nilaiUAS = Nilai::where('NIM', $NIM)
            ->where('id_kelas', $kelas->id_kelas)
            ->whereHas('aktifitas', fn($query) => $query->where('nama_aktifitas', 'UAS'))
            ->first();

        if ($nilaiUAS) {
            $totalBobot += ($nilaiUAS->nilai / 100) * 4.00 * ($bobotUAS / 100);
        }

        $nilaiLainnya = Nilai::where('NIM', $NIM)
            ->where('id_kelas', $kelas->id_kelas)
            ->whereHas('aktifitas', fn($query) => $query->where('nama_aktifitas', 'Lainnya'))
            ->first();

        if ($nilaiLainnya) {
            $totalBobot += ($nilaiLainnya->nilai / 100) * 4.00 * ($bobotLainnya / 100);
        }

        $nilaiTugas = Nilai::where('NIM', $NIM)
            ->where('id_kelas', $kelas->id_kelas)
            ->whereHas('aktifitas', fn($query) => $query->whereNotIn('nama_aktifitas', ['UTS', 'UAS', 'Lainnya']))
            ->get();

        if ($nilaiTugas->isNotEmpty()) {
            $averageTugas = $nilaiTugas->avg('nilai');
            $averageTugasScaled = ($averageTugas / 100) * 4.00;
            $totalBobot += $averageTugasScaled * ($bobotTugas / 100);
        }

        return round($totalBobot, 2);
    }



}
