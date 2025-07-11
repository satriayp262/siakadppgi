<?php

namespace Database\Seeders;

use App\Models\Aktifitas;
use App\Models\Dosen;
use App\Models\Matakuliah;
use App\Models\Nilai;
use App\Models\Pendidikan_Terakhir;
use App\Models\Pertanyaan;
use App\Models\Ruangan;
use App\Models\User;
use App\Models\Semester;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Kelas;
use App\Models\Pengumuman;
use App\Models\Staff;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => '123@gmail.com',
            'password' => '11111111',
            'role' => 'admin',
        ]);

        Staff::factory()->create([
            'nip' => '123456789',
            'nama_staff' => 'Fajar Dwi J',
            'email' => 'staff1@gmail.com',
            'ttd' => 'ttd.jpg',
        ]);

        Staff::factory()->create([
            'nip' => '98765421',
            'nama_staff' => 'Budi Sasono',
            'email' => 'staff2@gmail.com',
            'ttd' => 'ttd2.png',
        ]);

        Staff::factory()->create([
            'nip' => '234567567',
            'nama_staff' => 'Siti Fatimah',
            'email' => 'staff3@gmail.com',
            'ttd' => 'ttd3.png',
        ]);


        User::factory()->create([
            'name' => 'Fajar Dwi J',
            'email' => 'staff1@gmail.com',
            'password' => 'staff1@gmail.com',
            'role' => 'staff',
            'nim_nidn' => '123456789',
        ]);

        User::factory()->create([
            'name' => 'Budi Sasono',
            'email' => 'staff2@gmail.com',
            'password' => 'staff2@gmail.com',
            'role' => 'staff',
            'nim_nidn' => '98765421',
        ]);

        User::factory()->create([
            'name' => 'Siti Fatimah',
            'email' => 'staff3@gmail.com',
            'password' => 'staff3@gmail.com',
            'role' => 'staff',
            'nim_nidn' => '234567567',
        ]);


        $prodiData = [
            ['kode_prodi' => 'AK-001', 'nama_prodi' => 'Akutansi', 'jenjang' => 'D3'],
            ['kode_prodi' => 'MO-002', 'nama_prodi' => 'Mesin Otomotif', 'jenjang' => 'D3'],
            ['kode_prodi' => 'TE-003', 'nama_prodi' => 'Teknik Elektro', 'jenjang' => 'S1'],
            ['kode_prodi' => 'MSDM-004', 'nama_prodi' => 'Manajemen SDM', 'jenjang' => 'S1'],
        ];

        foreach ($prodiData as $prodi) {
            Prodi::factory()->create($prodi);
        }

        Semester::factory()->create([
            'nama_semester' => '20201',
            'bulan_mulai' => '2019-08',
            'bulan_selesai' => '2020-01',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20202',
            'bulan_mulai' => '2020-02',
            'bulan_selesai' => '2020-07',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20211',
            'bulan_mulai' => '2020-08',
            'bulan_selesai' => '2021-01',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20212',
            'bulan_mulai' => '2021-02',
            'bulan_selesai' => '2021-07',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20221',
            'bulan_mulai' => '2021-08',
            'bulan_selesai' => '2022-01',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20222',
            'bulan_mulai' => '2022-02',
            'bulan_selesai' => '2022-07',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20231',
            'bulan_mulai' => '2022-08',
            'bulan_selesai' => '2023-01',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20232',
            'bulan_mulai' => '2023-02',
            'bulan_selesai' => '2023-07',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20241',
            'bulan_mulai' => '2023-08',
            'bulan_selesai' => '2024-01',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20242',
            'bulan_mulai' => '2024-02',
            'bulan_selesai' => '2024-07',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20251',
            'bulan_mulai' => '2024-08',
            'bulan_selesai' => '2025-01',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20252',
            'bulan_mulai' => '2025-02',
            'bulan_selesai' => '2025-07',
            'is_active' => 1,
        ]);


        $pendidikanList = [
            ['kode_pendidikan_terakhir' => 0, 'nama_pendidikan_terakhir' => 'Tidak sekolah'],
            ['kode_pendidikan_terakhir' => 1, 'nama_pendidikan_terakhir' => 'PAUD'],
            ['kode_pendidikan_terakhir' => 2, 'nama_pendidikan_terakhir' => 'TK / sederajat'],
            ['kode_pendidikan_terakhir' => 3, 'nama_pendidikan_terakhir' => 'Putus SD'],
            ['kode_pendidikan_terakhir' => 4, 'nama_pendidikan_terakhir' => 'SD / sederajat'],
            ['kode_pendidikan_terakhir' => 5, 'nama_pendidikan_terakhir' => 'SMP / sederajat'],
            ['kode_pendidikan_terakhir' => 6, 'nama_pendidikan_terakhir' => 'SMA / sederajat'],
            ['kode_pendidikan_terakhir' => 7, 'nama_pendidikan_terakhir' => 'Paket A'],
            ['kode_pendidikan_terakhir' => 8, 'nama_pendidikan_terakhir' => 'Paket B'],
            ['kode_pendidikan_terakhir' => 9, 'nama_pendidikan_terakhir' => 'Paket C'],
            ['kode_pendidikan_terakhir' => 20, 'nama_pendidikan_terakhir' => 'D1'],
            ['kode_pendidikan_terakhir' => 21, 'nama_pendidikan_terakhir' => 'D2'],
            ['kode_pendidikan_terakhir' => 22, 'nama_pendidikan_terakhir' => 'D3'],
            ['kode_pendidikan_terakhir' => 23, 'nama_pendidikan_terakhir' => 'D4'],
            ['kode_pendidikan_terakhir' => 30, 'nama_pendidikan_terakhir' => 'S1'],
            ['kode_pendidikan_terakhir' => 31, 'nama_pendidikan_terakhir' => 'Profesi'],
            ['kode_pendidikan_terakhir' => 32, 'nama_pendidikan_terakhir' => 'Sp-1'],
            ['kode_pendidikan_terakhir' => 35, 'nama_pendidikan_terakhir' => 'S2'],
            ['kode_pendidikan_terakhir' => 36, 'nama_pendidikan_terakhir' => 'S2 Terapan'],
            ['kode_pendidikan_terakhir' => 37, 'nama_pendidikan_terakhir' => 'Sp-2'],
            ['kode_pendidikan_terakhir' => 40, 'nama_pendidikan_terakhir' => 'S3'],
            ['kode_pendidikan_terakhir' => 41, 'nama_pendidikan_terakhir' => 'S3 Terapan'],
            ['kode_pendidikan_terakhir' => 90, 'nama_pendidikan_terakhir' => 'Non formal'],
            ['kode_pendidikan_terakhir' => 91, 'nama_pendidikan_terakhir' => 'Informal'],
            ['kode_pendidikan_terakhir' => 99, 'nama_pendidikan_terakhir' => 'Lainnya'],
        ];

        foreach ($pendidikanList as $pendidikan) {
            Pendidikan_Terakhir::create($pendidikan);
        }

        $dosens = Dosen::factory(36)->create();

        $dosenCount = $dosens->count();

        // Define the list of kode_prodi
        $kodeProdis = ['AK-001', 'MO-002', 'TE-003', 'MSDM-004'];
        $mataKuliahNames = [
            'Statistika',
            'Pemrograman Web',
            'Basis Data',
            'Mobile Programming',
            'Sistem Operasi',
            'RPL',
            'PBO',
            'Algoritma',
            'Jaringan Komputer',
            'AI Dasar',
            'UI/UX',
            'Etika Profesi',
            'Kalkulus',
            'Pemrograman Dasar',
            'Manajemen Proyek',
            'Data Mining',
            'Sistem Informasi',
            'E-Business',
            'Pemrograman Framework',
            'Cloud Computing'
        ];

        $dosenIndex = 0;

        $usedCodes = [];

        foreach ($kodeProdis as $kodeProdi) {
            for ($i = 0; $i < 20; $i++) {
                $mataKuliahName = $mataKuliahNames[$i % count($mataKuliahNames)];
                $abbreviation = strtoupper(implode('', array_map(fn($word) => $word[0], explode(' ', $mataKuliahName))));
                $baseCode = substr($abbreviation, 0, 6) . substr(str_replace('-', '', $kodeProdi), 0, 2);

                // Ensure uniqueness
                $finalCode = $baseCode;
                $suffix = 1;
                while (in_array($finalCode, $usedCodes)) {
                    $finalCode = $baseCode . $suffix;
                    $suffix++;
                }

                $usedCodes[] = $finalCode;

                $assignedDosen = $dosens[$dosenIndex % $dosenCount];

                Matakuliah::create([
                    'kode_mata_kuliah' => $finalCode,
                    'nama_mata_kuliah' => $mataKuliahName,
                    'kode_prodi' => $kodeProdi,
                    'jenis_mata_kuliah' => fake()->randomElement(['A', 'W', 'P', 'B', 'C', 'S']),
                    'nidn' => $assignedDosen->nidn,
                    'sks_tatap_muka' => 2,
                    'sks_praktek' => 0,
                    'sks_praktek_lapangan' => 0,
                    'sks_simulasi' => 0,
                    'metode_pembelajaran' => fake()->randomElement(['Online', 'Offline']),
                    'tgl_mulai_efektif' => fake()->date(),
                    'tgl_akhir_efektif' => fake()->date()
                ]);

                $dosenIndex++;
            }
        }

        foreach ($prodiData as $data) {
            $xx = str_split($data['kode_prodi'], 2)[0];
            $x = ['A/' . $xx . '/22', 'B/' . $xx . '/22'];
            foreach ($x as $y) {
                Kelas::create([
                    'id_semester' => 5,
                    'nama_kelas' => $y,
                    'kode_prodi' => $data['kode_prodi'],
                    'lingkup_kelas' => fake()->randomElement([1, 2, 3]),
                    'bahasan' => fake()->sentence(),
                    'mode_kuliah' => fake()->randomElement(['O', 'F', 'M']),
                ]);
            }
        }

        Ruangan::factory(20)->create();

        Pengumuman::factory()->create([
            'title' => '"Engineering Creativity Design Competition (ECDC) 2021"',
            'desc' => 'Ayo ikut serta dalam Engineering Creativity Design Competition (ECDC) 2021, kompetisi nasional yang mengundang mahasiswa Indonesia untuk menciptakan karya inovatif di bidang teknik dan desain! Pilih salah satu dari lima kategori menarik, seperti desain kendaraan listrik masa depan atau aplikasi pembelajaran inovatif 5.0. Daftarkan dirimu atau timmu sekarang, unggah karyamu sebelum 10 Desember 2021, dan raih kesempatan memenangkan hadiah menarik serta e-sertifikat! Jangan lewatkan kesempatan untuk menunjukkan kreativitasmu di tingkat nasional!',
            'image' => 'pengumuman1.jpeg',
        ]);

        Pertanyaan::factory()->create([
            'nama_pertanyaan' => 'Ketepatan waktu mengajar dosen'
        ]);

        Pertanyaan::factory()->create([
            'nama_pertanyaan' => 'Penampilan berpakaian dosen'
        ]);

        Pertanyaan::factory()->create([
            'nama_pertanyaan' => 'Pemberian motivasi kepada mahasiswa'
        ]);

        Pertanyaan::factory()->create([
            'nama_pertanyaan' => 'Penguasaan dosen terhadap materi kuliah '
        ]);

        Pertanyaan::factory()->create([
            'nama_pertanyaan' => 'Kesempatan diskusi/latihan perkuliahan'
        ]);

        Pertanyaan::factory()->create([
            'nama_pertanyaan' => 'kejelasan pemberian mata kuliah'
        ]);

        Pertanyaan::factory()->create([
            'nama_pertanyaan' => 'kejelasan menjawab pertanyaan mahasiswa'
        ]);
        Pertanyaan::factory()->create([
            'nama_pertanyaan' => 'sistematika penyajian mata kuliah'
        ]);

        DB::table('komponen_kartu_ujian')->insert([
            'jabatan' => 'Wakil Direktur Bidang Akademik',
            'nama' => 'santoso'
        ]);

    }
}
