<?php

namespace Database\Seeders;

use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\paketKRS;
use App\Models\Semester;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswa = Mahasiswa::all();
        $semester = Semester::all();
        $total = count($mahasiswa);
        $counter = 0;

        foreach ($mahasiswa as $m) {
            foreach ($semester as $s) {
                $paketKRS = paketKRS::where('id_semester', $s->id_semester)
                    ->where('id_prodi', $m->prodi->id_prodi)
                    ->where('id_kelas', $m->id_kelas)
                    ->get();

                foreach ($paketKRS as $p) {
                    KRS::create([
                        'id_semester' => $s->id_semester,
                        'NIM' => $m->NIM,
                        'id_kelas' => $p->id_kelas,
                        'id_mata_kuliah' => $p->id_mata_kuliah,
                        'id_prodi' => $p->id_prodi
                    ]);
                }
            }
            $counter++;
            echo "\r$counter/$total done";
        }
        $allKrs = KRS::orderBy('id_kelas')->orderBy('id_krs')->get();

        $groupedByKelas = $allKrs->groupBy('id_kelas');

        foreach ($groupedByKelas as $idKelas => $krsList) {
            $total = $krsList->count();
            $half = ceil($total / 2);

            foreach ($krsList as $index => $krs) {
                $grup = ($index < $half) ? 'A' : 'B';
                $krs->update(['grup_praktikum' => $grup]);
            }
        }

        echo "\n";
    }
}
