<?php

namespace Database\Seeders;

use App\Models\KRS;
use App\Models\MahasiswaEmonev;
use App\Models\Matakuliah;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmonevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // Get all unique NIMs from KRS
            $nims = KRS::distinct()->pluck('NIM');

            foreach ($nims as $nim) {
                // Get all unique semesters for this NIM
                $semesters = KRS::where('NIM', $nim)->distinct()->pluck('id_semester');

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
                            // Create or update mahasiswa_emonev entry
                            MahasiswaEmonev::updateOrCreate([
                                'NIM' => $nim,
                                'id_semester' => $id_semester,
                                'id_mata_kuliah' => $krs->id_mata_kuliah,
                                'nidn' => Matakuliah::where('id_mata_kuliah', $krs->id_mata_kuliah)->first()->nidn,
                                'sesi' => 2,
                            ]);
                        } catch (\Exception $e) {
                            echo "Error updating NIM: $nim, Semester: $id_semester. Error: " . $e->getMessage() . "\n";
                        }
                    }
                }
            }
        });

        echo "Mahasiswa Emonev Seeder Completed.";

    }
}
