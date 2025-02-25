<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
    public static function calculateBobot($id_semester, $NIM, $id_mata_kuliah, $id_kelas)
    {

        $krsEntries = KRS::where('NIM', $NIM)
            ->where('id_semester', $id_semester)
            ->get();

        if ($krsEntries->isEmpty()) {
            throw new \Exception('KRS entries not found for the given NIM and semester.');
        }
        $cek = 1;

        $matkul = matakuliah::where('id_mata_kuliah', $id_mata_kuliah)->first();

        if (!$matkul) {
            throw new \Exception('Matakuliah not found for the given KHS.');
        }

        $bobot = Bobot::firstOrCreate([
            'id_kelas' => $id_kelas,
            'id_mata_kuliah' => $id_mata_kuliah
        ]);
        $bobotTugas = $bobot->tugas ?? 0;
        $bobotUTS = $bobot->uts ?? 0;
        $bobotUAS = $bobot->uas ?? 0;
        $bobotPartisipasi = $bobot->partisipasi ?? 0;

        $totalWeight = $bobotTugas + $bobotUTS + $bobotUAS + $bobotPartisipasi;

        if ($totalWeight != 100 && $totalWeight != 0) {
            $bobotTugas = ($bobotTugas / $totalWeight) * 100;
            $bobotUTS = ($bobotUTS / $totalWeight) * 100;
            $bobotUAS = ($bobotUAS / $totalWeight) * 100;
            $bobotPartisipasi = ($bobotPartisipasi / $totalWeight) * 100;
        }

        $aktifitas = Aktifitas::where('id_kelas', $id_kelas)
            ->where('id_mata_kuliah', $id_mata_kuliah)->get();

        if ($aktifitas->isEmpty()) {
            return 0;
        }

        $TotalNilai = $NilaiUAS = $NilaiUTS = $NilaiPartisipasi = $JumlahnilaiTugas = $JumlahTugas = 0;

        foreach ($aktifitas as $y) {
            $nilai = Nilai::where('NIM', $NIM)
                ->where('id_aktifitas', $y->id_aktifitas)
                ->value('nilai') ?? 0;

            switch ($y->nama_aktifitas) {
                case 'UAS':
                    $NilaiUAS = $nilai;
                    break;
                case 'UTS':
                    $NilaiUTS = $nilai;
                    break;
                default:
                    $JumlahTugas++;
                    $JumlahnilaiTugas += $nilai;
                    break;
            }
        }

            $PresensiCount = Presensi::where('id_mata_kuliah', $id_mata_kuliah)
                ->where('id_kelas', $id_kelas)
                ->get();

            $totalPresensi = $PresensiCount->count();
            $hadirCount = $PresensiCount->where('keterangan', 'Hadir')->count();

            if($totalPresensi != 0){
                $NilaiPartisipasi = ($hadirCount / $totalPresensi) * 100;
            }else{
            $NilaiPartisipasi = 0;
            }




        $TotalNilai += (($JumlahnilaiTugas / $JumlahTugas)) * ($bobotTugas / 100);

        $TotalNilai += $NilaiUAS * ($bobotUAS / 100);

        $TotalNilai += $NilaiUTS * ($bobotUTS / 100);

        $TotalNilai += $NilaiPartisipasi * ($bobotPartisipasi / 100);

        // dd($TotalNilai ,$JumlahnilaiTugas / $JumlahTugas,$NilaiUAS,$NilaiUTS,$NilaiPartisipasi );

        return round($TotalNilai);
    }

    public $bobotNilai = [
        ['min' => 80, 'max' => 100, 'huruf' => 'A', 'angka' => 4],
        ['min' => 70, 'max' => 79, 'huruf' => 'B', 'angka' => 3],
        ['min' => 60, 'max' => 69, 'huruf' => 'C', 'angka' => 2],
        ['min' => 50, 'max' => 59, 'huruf' => 'D', 'angka' => 1],
        ['min' => 0, 'max' => 49, 'huruf' => 'E', 'angka' => 0],
    ];

    public function getGrade($nilai)
    {
        foreach ($this->bobotNilai as $bobot) {
            if ($nilai >= $bobot['min'] && $nilai <= $bobot['max']) {
                return [
                    'huruf' => $bobot['huruf'],
                    'angka' => $bobot['angka']
                ];
            }
        }

        return ['huruf' => 'Error', 'angka' => 0];
    }


}

