<?php

namespace Database\Seeders;

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
            $aktifitasList = ['UAS', 'UTS', 'Tugas 1', 'Tugas 2', 'Tugas 3', 'Tugas 4', 'Tugas 5', 'Lainnya'];

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
                            'nilai' => rand(70, 100), // Nilai random antara 50-100
                        ]
                    );
                }
            }
        });

        echo "Done";
    }
}
