<?php

namespace Database\Seeders;

use App\Models\KHS;
use Illuminate\Database\Seeder;
use App\Models\KRS;
use App\Models\Nilai;
use App\Models\Aktifitas;
use Illuminate\Support\Facades\DB;

class NilaiSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            $aktifitasList = ['UAS', 'UTS', 'Tugas 1', 'Tugas 2', 'Tugas 3', 'Tugas 4', 'Tugas 5', 'Partisipasi'];

            $krsRecords = KRS::all();

            foreach ($krsRecords as $krs) {

                foreach ($aktifitasList as $namaAktifitas) {
                    // Buat atau ambil aktifitas yang sesuai
                    $aktifitas = Aktifitas::firstOrCreate(
                        [
                            'nama_aktifitas' => $namaAktifitas,
                            'id_kelas' => $krs->id_kelas,
                            'id_mata_kuliah' => $krs->id_mata_kuliah,
                        ],
                        [
                            'catatan' => "Aktifitas $namaAktifitas",
                        ]
                    );

                    // Perbarui atau buat nilai
                    Nilai::updateOrCreate(
                        [
                            'NIM' => $krs->NIM,
                            'id_aktifitas' => $aktifitas->id_aktifitas,
                        ],
                        [
                            'id_kelas' => $krs->id_kelas,
                            'nilai' => rand(35, 100),
                        ]
                    );
                }

            }
        });

        $nims = KRS::distinct()->pluck('NIM');
        $counter = 0;
        foreach ($nims as $nim) {
            // Get all unique semesters for this NIM
            $semesters = KRS::where('NIM', $nim)->distinct()->pluck('id_semester');
            $total = count($nims);
            foreach ($semesters as $id_semester) {
                // Retrieve the KRS data for the given NIM and semester
                $krsData = KRS::where('NIM', $nim)
                    ->where('id_semester', $id_semester)
                    ->get();

                // Skip if there's no KRS data
                if ($krsData->isEmpty()) {
                    continue;
                }

                foreach ($krsData as $krs) {
                    try {
                        // Call the KHS model to calculate the bobot
                        $bobot = KHS::calculateBobot($id_semester, $nim, $krs->id_mata_kuliah, $krs->id_kelas);

                        // Create or update the KHS entry
                        KHS::updateOrCreate([
                            'id_krs' => $krs->id_krs
                        ], [
                            'bobot' => $bobot
                        ]);

                    } catch (\Exception $e) {
                        echo "Error updating NIM: $nim, Semester: $id_semester. Error: " . $e->getMessage() . "\n";
                    }
                }
            }
            $counter++;
            echo "\r$counter/$total done";
        }
        echo "\n";
    }
}
