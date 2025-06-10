<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Matakuliah;
use App\Models\paketKRS;
use App\Models\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaketKRSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $semester = [9, 10, 11, 12];
        $prodi = Prodi::all();

        foreach ($prodi as $p) {
            // Select the appropriate mata kuliah once per prodi
            if ($p->kode_prodi == 'AK-001' || $p->kode_prodi == 'MO-002') {
                $allMataKuliah = Matakuliah::where('kode_prodi', $p->kode_prodi)->get();
            } else {
                $A = Matakuliah::where('kode_prodi', $p->kode_prodi)->get()->unique('kode_mata_kuliah');
                $all = Matakuliah::where('kode_prodi', $p->kode_prodi)->get();
                $B = $all->diff($A);
                $allMataKuliah = $A->merge($B);
            }

            // Ensure enough mata kuliah
            if ($allMataKuliah->count() < count($semester) * 5) {
                continue; // or log warning
            }

            // Shuffle once and split into chunks of 5 for each semester
            $chunks = $allMataKuliah->shuffle()->values()->chunk(5);
            if ($chunks->count() < count($semester))
                continue;

            $kelas = Kelas::where('kode_prodi', $p->kode_prodi)->get();

            foreach ($kelas as $k) {
                foreach ($semester as $index => $s) {
                    $MataKuliah = $chunks[$index];

                    foreach ($MataKuliah as $m) {
                        paketKRS::create([
                            'id_semester' => $s,
                            'id_prodi' => $p->id_prodi,
                            'id_mata_kuliah' => $m->id_mata_kuliah,
                            'id_kelas' => $k->id_kelas,
                            'tanggal_mulai' => '2025-03-10',
                            'tanggal_selesai' => '2025-04-10',
                        ]);
                    }
                }
            }
        }


    }
}
