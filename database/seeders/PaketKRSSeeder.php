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
        $semester = [5, 6, 7];
        $prodi = Prodi::all();
        foreach ($semester as $s) {
            foreach ($prodi as $p) {
                $kelas = Kelas::where('kode_prodi', $p->kode_prodi)->get();
                foreach ($kelas as $k) {
                    if ($p->kode_prodi == 'AK-001' || $p->kode_prodi == 'MO-002') {
                        $MataKuliah = Matakuliah::where('kode_prodi', $p->kode_prodi)->get();
                    } else {
                        $A = Matakuliah::where('kode_prodi', $p->kode_prodi)
                            ->get()
                            ->unique('kode_mata_kuliah');
                        $all = Matakuliah::where('kode_prodi', $p->kode_prodi)->get();
                        $B = $all->diff($A);
                        if (str_starts_with($k->nama_kelas, 'A')) {
                            $MataKuliah = $A;
                        } else {
                            $MataKuliah = $B;
                        }
                        echo ($p->kode_prodi . " " . $k->nama_kelas . " " . $s . " " . count($A) . " " . count($all) . " " . count($B) . " \n");
                    }
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
