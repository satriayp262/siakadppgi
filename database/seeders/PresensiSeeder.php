<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Presensi;
use App\Models\Token;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Semester;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PresensiSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user dosen dari semua NIDN di matakuliah
        $nidns = Matakuliah::pluck('nidn')->unique();

        foreach ($nidns as $nidn) {
            User::firstOrCreate(
                ['nim_nidn' => $nidn],
                [
                    'name' => 'Dosen ' . $nidn,
                    'email' => 'dosen' . $nidn . '@example.com',
                    'password' => bcrypt('password'),
                    'role' => 'dosen',
                ]
            );
        }

        $mataKuliahs = Matakuliah::all();
        $semester = Semester::where('is_active', 1)->first();

        if (!$semester) {
            echo "❌ Semester aktif tidak ditemukan\n";
            return;
        }

        foreach ($mataKuliahs as $mataKuliah) {
            echo "Processing Mata Kuliah ID: {$mataKuliah->id_mata_kuliah}\n";

            $dosenUser = User::where('nim_nidn', $mataKuliah->nidn)->first();
            if (!$dosenUser) {
                echo "  ❌ Dosen user tidak ditemukan untuk NIDN: {$mataKuliah->nidn}\n";
                continue;
            }

            $krsRecords = KRS::where('id_mata_kuliah', $mataKuliah->id_mata_kuliah)->get();
            if ($krsRecords->isEmpty()) {
                echo "  ⚠️ Tidak ada mahasiswa KRS untuk matakuliah ini\n";
                continue;
            }

            $kelasIds = $krsRecords->pluck('id_kelas')->unique()->values();

            foreach ($kelasIds as $kelasId) {
                echo "- Processing Kelas ID: {$kelasId}\n";

                $kelas = Kelas::find($kelasId);
                if (!$kelas) {
                    echo "  ❌ Kelas ID {$kelasId} tidak ditemukan\n";
                    continue;
                }

                $jadwal = Jadwal::where('id_mata_kuliah', $mataKuliah->id_mata_kuliah)
                    ->where('id_kelas', $kelasId)
                    ->where('nidn', $mataKuliah->nidn)
                    ->first();

                $hari = $jadwal->hari ?? 'Senin';
                $sesi = $jadwal->sesi ?? '1';

                foreach (range(1, 12) as $pertemuan) {
                    echo "    - Membuat Token Pertemuan {$pertemuan}\n";

                    $token = Token::create([
                        'token' => Str::upper(Str::random(6)),
                        'id_mata_kuliah' => $mataKuliah->id_mata_kuliah,
                        'id_kelas' => $kelas->id_kelas,
                        'id_semester' => $semester->id_semester,
                        'valid_until' => Carbon::now()->addDay(),
                        'hari' => $hari,
                        'sesi' => $sesi,
                        'pertemuan' => $pertemuan,
                        'id' => $dosenUser->id,
                    ]);

                    $mahasiswaList = $krsRecords->where('id_kelas', $kelasId);

                    foreach ($mahasiswaList as $krs) {
                        $mahasiswa = Mahasiswa::where('NIM', $krs->NIM)->first();

                        if (!$mahasiswa) {
                            echo "      ⚠️ Mahasiswa NIM {$krs->NIM} tidak ditemukan\n";
                            continue;
                        }

                        // Tentukan keterangan: Hadir, Izin, Sakit, Alpha (sedikit)
                        $random = rand(1, 100);
                        if ($random <= 85) {
                            $keterangan = 'Hadir';
                        } elseif ($random <= 95) {
                            $keterangan = ['Izin', 'Sakit'][rand(0, 1)];
                        } else {
                            $keterangan = 'Alpha'; // hanya 5% kemungkinan
                        }

                        Presensi::create([
                            'nama' => $mahasiswa->nama,
                            'nim' => $mahasiswa->NIM,
                            'token' => $token->token,
                            'waktu_submit' => Carbon::now(),
                            'keterangan' => $keterangan,
                            'alasan' => null,
                            'id_kelas' => $kelas->id_kelas,
                            'id_mata_kuliah' => $mataKuliah->id_mata_kuliah,
                        ]);
                    }
                }
            }
        }
    }
}
