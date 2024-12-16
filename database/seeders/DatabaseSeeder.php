<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Matakuliah;
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


        Prodi::factory()->create([
            'kode_prodi' => 'AK-001',
            'nama_prodi' => 'Akutansi',
            'jenjang' => 'D3',

        ]);
        Prodi::factory()->create([
            'kode_prodi' => 'MO-002',
            'nama_prodi' => 'Mesin Otomotif',
            'jenjang' => 'D3',

        ]);
        Prodi::factory()->create([
            'kode_prodi' => 'TE-003',
            'nama_prodi' => 'Teknik Elektro',
            'jenjang' => 'S1',

        ]);
        Prodi::factory()->create([
            'kode_prodi' => 'MSDM-004',
            'nama_prodi' => 'Manajemen SDM',
            'jenjang' => 'S1',
        ]);


        Semester::factory()->create([
            'nama_semester' => '20201',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20202',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20211',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20212',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20221',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20222',
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

        Dosen::factory(30)->create();

        $matakuliahData = [
            [
                'kode_mata_kuliah' => 'STATIS_AK',
                'nama_mata_kuliah' => 'Statistika',
                'kode_prodi' => 'AK-001'
            ],
            [
                'kode_mata_kuliah' => 'PROWEB_AK',
                'nama_mata_kuliah' => 'Pemrograman Web',
                'kode_prodi' => 'AK-001'
            ],
            [
                'kode_mata_kuliah' => 'BASDAT_AK',
                'nama_mata_kuliah' => 'Basis Data',
                'kode_prodi' => 'AK-001'
            ],
            [
                'kode_mata_kuliah' => 'MOBILE_AK',
                'nama_mata_kuliah' => 'Mobile Programming',
                'kode_prodi' => 'AK-001'
            ],
            [
                'kode_mata_kuliah' => 'SISTOP_AK',
                'nama_mata_kuliah' => 'Sistem Operasi',
                'kode_prodi' => 'AK-001'
            ],
            [
                'kode_mata_kuliah' => 'ERPEEL_AK',
                'nama_mata_kuliah' => 'RPL',
                'kode_prodi' => 'AK-001'
            ],
            [
                'kode_mata_kuliah' => 'STATIS_MO',
                'nama_mata_kuliah' => 'Statistika',
                'kode_prodi' => 'MO-002'
            ],
            [
                'kode_mata_kuliah' => 'PROWEB_MO',
                'nama_mata_kuliah' => 'Pemrograman Web',
                'kode_prodi' => 'MO-002'
            ],
            [
                'kode_mata_kuliah' => 'BASDAT_MO',
                'nama_mata_kuliah' => 'Basis Data',
                'kode_prodi' => 'MO-002'
            ],
            [
                'kode_mata_kuliah' => 'MOBILE_MO',
                'nama_mata_kuliah' => 'Mobile Programming',
                'kode_prodi' => 'MO-002'
            ],
            [
                'kode_mata_kuliah' => 'SISTOP_MO',
                'nama_mata_kuliah' => 'Sistem Operasi',
                'kode_prodi' => 'MO-002'
            ],
            [
                'kode_mata_kuliah' => 'ERPEEL_MO',
                'nama_mata_kuliah' => 'RPL',
                'kode_prodi' => 'MO-002'
            ],
            [
                'kode_mata_kuliah' => 'STATIS_TE',
                'nama_mata_kuliah' => 'Statistika',
                'kode_prodi' => 'TE-003'
            ],
            [
                'kode_mata_kuliah' => 'PROWEB_TE',
                'nama_mata_kuliah' => 'Pemrograman Web',
                'kode_prodi' => 'TE-003'
            ],
            [
                'kode_mata_kuliah' => 'BASDAT_TE',
                'nama_mata_kuliah' => 'Basis Data',
                'kode_prodi' => 'TE-003'
            ],
            [
                'kode_mata_kuliah' => 'MOBILE_TE',
                'nama_mata_kuliah' => 'Mobile Programming',
                'kode_prodi' => 'TE-003'
            ],
            [
                'kode_mata_kuliah' => 'SISTOP_TE',
                'nama_mata_kuliah' => 'Sistem Operasi',
                'kode_prodi' => 'TE-003'
            ],
            [
                'kode_mata_kuliah' => 'ERPEEL_TE',
                'nama_mata_kuliah' => 'RPL',
                'kode_prodi' => 'TE-003'
            ],
            [
                'kode_mata_kuliah' => 'STATIS_MSDM',
                'nama_mata_kuliah' => 'Statistika',
                'kode_prodi' => 'MSDM-004'
            ],
            [
                'kode_mata_kuliah' => 'PROWEB_MSDM',
                'nama_mata_kuliah' => 'Pemrograman Web',
                'kode_prodi' => 'MSDM-004'
            ],
            [
                'kode_mata_kuliah' => 'BASDAT_MSDM',
                'nama_mata_kuliah' => 'Basis Data',
                'kode_prodi' => 'MSDM-004'
            ],
            [
                'kode_mata_kuliah' => 'MOBILE_MSDM',
                'nama_mata_kuliah' => 'Mobile Programming',
                'kode_prodi' => 'MSDM-004'
            ],
            [
                'kode_mata_kuliah' => 'SISTOP_MSDM',
                'nama_mata_kuliah' => 'Sistem Operasi',
                'kode_prodi' => 'MSDM-004'
            ],
            [
                'kode_mata_kuliah' => 'ERPEEL_MSDM',
                'nama_mata_kuliah' => 'RPL',
                'kode_prodi' => 'MSDM-004'
            ],
        ];

        $nidnlist = Dosen::pluck('nidn')->toArray();


        foreach ($matakuliahData as $data) {
            $mataKuliah = Matakuliah::create([
                'kode_mata_kuliah' => $data['kode_mata_kuliah'],
                'nama_mata_kuliah' => $data['nama_mata_kuliah'],
                'kode_prodi' => $data['kode_prodi'],
                'jenis_mata_kuliah' => fake()->randomElement(['A', 'W', 'B', 'C', 'S']),
                'nidn' => fake()->randomElement($nidnlist),
                'sks_tatap_muka' => fake()->numberBetween(1, 4),
                'sks_praktek' => fake()->numberBetween(0, 2),
                'sks_praktek_lapangan' => fake()->numberBetween(0, 2),
                'sks_simulasi' => fake()->numberBetween(0, 2),
                'metode_pembelajaran' => fake()->randomElement(['Online', 'Offline']),
                'tgl_mulai_efektif' => fake()->date(),
                'tgl_akhir_efektif' => fake()->date(),
            ]);

            // Create 2 Kelas for each Mata Kuliah
            for ($semester = 6; $semester >= 5; $semester--) {
                Kelas::create([
                    'id_semester' => $semester,
                    'nama_kelas' => strtolower($data['kode_mata_kuliah']),
                    'kode_prodi' => $data['kode_prodi'],
                    'id_mata_kuliah' => $mataKuliah->id_mata_kuliah,
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
            'nama_pertanyaan' => 'Penampilan berpakaian dosen (Rate Outfit) '
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

    }
}
