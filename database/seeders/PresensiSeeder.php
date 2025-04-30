<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\KHS;
use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Presensi;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Log;
use Str;

class PresensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mataKuliahs = Matakuliah::all(); // Get all mata kuliah

        foreach ($mataKuliahs as $mataKuliah) {
            try {
                echo "Processing Mata Kuliah ID: {$mataKuliah->id_mata_kuliah}\n";

                // Get all mahasiswa in this mata kuliah & kelas
                $khsRecords = KRS::where('id_mata_kuliah', $mataKuliah->id_mata_kuliah)->get();

                if ($khsRecords->isEmpty()) {
                    echo "No KHS records found for Mata Kuliah ID: {$mataKuliah->id_mata_kuliah}\n";
                    continue;
                }

                $kelasIds = $khsRecords->pluck('id_kelas')->unique()->values()->toArray();
                echo "Found " . count($kelasIds) . " unique kelas IDs\n";

                foreach ($kelasIds as $id) {
                    try {
                        
                        $kelas = Kelas::where('id_kelas', $id)->first();

                        if (!$kelas) {
                            echo "No Kelas found for ID: {$id}\n";
                            continue;
                        }

                        $krs = KRS::where('id_mata_kuliah', $mataKuliah->id_mata_kuliah)
                        ->where('id_kelas', $id)->first();
                        $id = User::where('nim_nidn', $mataKuliah->nidn)->first()->id;
                        // Generate 12 tokens for this mata kuliah
                        $tokens = [];
                        foreach (range(1, 12) as $i) {
                            try {
                                $token = Token::create([
                                    'token' => Str::random(10),
                                    'id_mata_kuliah' => $mataKuliah->id_mata_kuliah,
                                    'id_kelas' => $kelas->id_kelas,
                                    'id_semester' => $krs->id_semester,
                                    'valid_until' => Carbon::now()->addDays(1),
                                    'id' => $id
                                ]);
                                $tokens[] = $token;
                            } catch (\Exception $e) {
                                echo "Error creating token: " . $e->getMessage() . "\n";
                            }
                        }

                        // For each token, create presensi for every mahasiswa
                        foreach ($tokens as $token) {
                            foreach ($khsRecords as $khs) {
                                try {
                                    $mahasiswaNama = Mahasiswa::where('nim', $khs->NIM)->value('nama');

                                    if (!$mahasiswaNama) {
                                        echo "No Mahasiswa found for NIM: {$khs->NIM}\n";
                                        continue;
                                    }

                                    Presensi::create([
                                        'nama' => $mahasiswaNama,
                                        'nim' => $khs->NIM,
                                        'token' => $token->token,
                                        'waktu_submit' => Carbon::now(),
                                        'keterangan' => (rand(1, 10) <= 9) ? 'Hadir' : ['Sakit', 'Izin', 'Alpha'][array_rand(['Sakit', 'Izin', 'Alpha'])],
                                        'alasan' => null,
                                        'id_kelas' => $khs->id_kelas,
                                        'id_mata_kuliah' => $khs->id_mata_kuliah,
                                    ]);

                                } catch (\Exception $e) {
                                    echo "Error creating Presensi for NIM: {$khs->NIM}. Error: " . $e->getMessage() . "\n";
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        echo "Error processing Kelas ID: {$id}. Error: " . $e->getMessage() . "\n";
                    }
                }
            } catch (\Exception $e) {
                echo "Error processing Mata Kuliah ID: {$mataKuliah->id_mata_kuliah}. Error: " . $e->getMessage() . "\n";
            }
        }
    }
}
