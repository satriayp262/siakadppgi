<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\Krs;
use App\Models\Presensi;
use App\Models\Semester;
use App\Models\Token;
use App\Models\User;
use App\Models\MataKuliah;
use App\Models\Jadwal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PresensiSeeder extends Seeder
{
    public function run(): void
    {
        $semester = Semester::latest()->first();
        if (!$semester) {
            echo "❌ Semester tidak ditemukan\n";
            return;
        }

        $mataKuliahList = MataKuliah::all();
        $krsRecords = Krs::all();

        foreach ($mataKuliahList as $mataKuliah) {
            $kelasIds = $krsRecords->where('id_mata_kuliah', $mataKuliah->id_mata_kuliah)->pluck('id_kelas')->unique();

            foreach ($kelasIds as $kelasId) {
                $kelas = Kelas::find($kelasId);
                if (!$kelas) continue;

                $dosenUser = User::where('nim_nidn', $mataKuliah->nidn)->first();
                if (!$dosenUser) continue;

                $jadwal = Jadwal::where('id_mata_kuliah', $mataKuliah->id_mata_kuliah)
                    ->where('id_kelas', $kelas->id_kelas)
                    ->where('nidn', $mataKuliah->nidn)
                    ->first();

                if (!$jadwal) {
                    echo "  ❌ Jadwal tidak ditemukan untuk MK {$mataKuliah->id_mata_kuliah}, kelas {$kelasId}\n";
                    continue;
                }

                $hariMap = [
                    'Senin' => Carbon::MONDAY,
                    'Selasa' => Carbon::TUESDAY,
                    'Rabu' => Carbon::WEDNESDAY,
                    'Kamis' => Carbon::THURSDAY,
                    'Jumat' => Carbon::FRIDAY,
                    'Sabtu' => Carbon::SATURDAY,
                    'Minggu' => Carbon::SUNDAY,
                ];

                $hariIndex = $hariMap[$jadwal->hari] ?? Carbon::MONDAY;

                $tanggalAwal = Carbon::parse($semester->bulan_mulai)->startOfWeek(Carbon::MONDAY);
                $tanggalPertamaJadwal = $tanggalAwal->copy()->next($hariIndex);
                $jamMulai = Carbon::parse($jadwal->jam_mulai)->format('H:i:s');
                $jamSelesai = Carbon::parse($jadwal->jam_selesai)->format('H:i:s');

                foreach (range(1, 12) as $pertemuan) {
                    $tanggalPresensi = $tanggalPertamaJadwal->copy()->addWeeks($pertemuan - 1)->setTimeFromTimeString($jamMulai);

                    // Buat datetime valid_until dengan tanggal hari itu + jam_selesai
                    $validUntil = Carbon::createFromFormat('H:i:s', $jamSelesai, 'Asia/Jakarta')
                        ->setDateFrom($tanggalPresensi);

                    $token = Token::create([
                        'token' => Str::upper(Str::random(6)),
                        'id_mata_kuliah' => $mataKuliah->id_mata_kuliah,
                        'id_kelas' => $kelas->id_kelas,
                        'id_semester' => $semester->id_semester,
                        'id_jadwal' => $jadwal->id_jadwal,
                        'valid_until' => $validUntil,
                        'pertemuan' => $pertemuan,
                        'id' => $dosenUser->id,
                        'created_at' => $tanggalPresensi,
                        'updated_at' => $tanggalPresensi,
                    ]);

                    $mahasiswaList = $krsRecords->where('id_kelas', $kelas->id_kelas);

                    foreach ($mahasiswaList as $krs) {
                        $mahasiswa = Mahasiswa::where('NIM', $krs->NIM)->first();
                        if (!$mahasiswa) continue;

                        $random = rand(1, 100);
                        $keterangan = match (true) {
                            $random <= 85 => 'Hadir',
                            $random <= 95 => ['Izin', 'Sakit'][rand(0, 1)],
                            default => 'Alpha',
                        };

                        Presensi::create([
                            'id_mahasiswa' => $mahasiswa->id_mahasiswa,
                            'token' => $token->token,
                            'keterangan' => $keterangan,
                            'alasan' => null,
                            'id_kelas' => $kelas->id_kelas,
                            'id_mata_kuliah' => $mataKuliah->id_mata_kuliah,
                            'created_at' => $tanggalPresensi,
                            'updated_at' => $tanggalPresensi,
                        ]);
                    }
                }
            }
        }

        echo "✅ Seeder selesai dijalankan dengan sukses.\n";
    }
}
