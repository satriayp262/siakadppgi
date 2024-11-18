<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromQuery;

class MahasiswaExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithEvents
{
    public function query()
    {
        return Mahasiswa::query()->with(['prodi', 'orangtuaWali']);
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'NIK',
            'Agama',
            'NISN',
            'Jalur Pendaftaran',
            'NPWP',
            'Kewarganegaraan',
            'Jenis Pendaftaran',
            'Tanggal Masuk Kuliah',
            'Mulai Semester',
            'Alamat',
            'Kode Pos',
            'Jenis Tinggal',
            'Alat Transportasi',
            'Telp Rumah',
            'No HP',
            'Email',
            'Terima KPS',
            'No KPS',
            'NIK Ayah',
            'Nama Ayah',
            'Tanggal Lahir Ayah',
            'Pendidikan Ayah',
            'Pekerjaan Ayah',
            'Penghasilan Ayah',
            'NIK Ibu',
            'Nama Ibu',
            'Tanggal Lahir Ibu',
            'Pendidikan Ibu',
            'Pekerjaan Ibu',
            'Penghasilan Ibu',
            'Nama Wali',
            'Tanggal Lahir Wali',
            'Pendidikan Wali',
            'Pekerjaan Wali',
            'Penghasilan Wali',
            'Kode Prodi',
            'Nama Prodi',
            'SKS Diakui',
            'Kode PT Asal',
            'Nama PT Asal',
            'Kode Prodi Asal',
            'Nama Prodi Asal',
            'Jenis Pembiayaan',
            'Jumlah Biaya Masuk',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $comments = [
                    'Isi dengan Nomor Induk Mahasiswa / Nomor Pokok Mahasiswa.',
                    'Nama lengkap mahasiswa tanpa gelar',
                    'Tempat lahir mahasiswa',
                    'Tanggal lahir mahasiswa dalam
Format: Tahun-Bulan-Tanggan
Contoh: 2000-02-20.',
                    'L : Laki-laki
P : Perempuan.',
                    'Nomor Induk Kependudukan mahasiswa(16 Digit).',
                    '1 : Islam
: Kristen
3 : Katholik
4 : Hindu
5 : Budha
6 : Konghuchu
99 : lainya',
                    'Isi dengan Nomor Induk Siswa Nasional. Wajib 10 digit',
                    '3: Penelusuran Minat dan Kemampuan (PMDK)
4: Prestasi
9: Program Internasional
11: Program Kerjasama Perusahaan/Institusi/Pemerintah
12: Seleksi Mandiri
13: Ujian Masuk Bersama Lainnya
14: Seleksi Nasional Berdasarkan Tes (SNBT)
15: Seleksi Nasional Berdasarkan Prestasi (SNBP)',
                    'Isi dengan Nomor Pokok Wajib Pajak jika ada. numerik, 16 karakter.',
                    'ID = Indonesia',
                    '1: Peserta didik baru
2: Pindahan
3: Naik Kelas
4: Akselerasi
5: Mengulang
6: Lanjutan semester
8: Pindahan Alih Bentuk
13: RPL Perolehan SKS
14: Pendidikan Non Gelar (Course)
15: Fast Track
16: RPL Transfer SKS',
                    'Format: Tahun-Bulan-Tanggan
Contoh: 2000-02-20.',
                    'Contoh : 
2021/2022 Ganjil diisi =20211
2021/2022 Genap diisi =20212
2021/2022 Pendek diisi =20213',
                    'Alamat mahasiswa.',
                    'isi dengan 5 digit Kode Pos',
                    '1: Bersama orang tua
2: Wali
3: Kost
4: Asrama
5: Panti asuhan
10: Rumah sendiri
99: Lainnya',
                    '1 Jalan kaki
3 Angkutan umum/bus/pete-pete
4 Mobil/bus antar jemput
5 Kereta api
6 Ojek
7 Andong/bendi/sado/dokar/delman/becak
8 Perahu penyeberangan/rakit/getek
11 Kuda
12 Sepeda
13 Sepeda motor
14 Mobil pribadi
99 Lainnya',
                    'Isi dengan Angka Tanpa Tanda Baca. Numerik, maksimal 20 karakter.',
                    'Numerik Maximal 20 digit',
                    'Isi dengan format email yang benar',
                    '1 : Ya
                    0 : tidak',
                    'Isi dengan No Kartu Perlindungan Sosial jika ada',
                    'Isi dengan 16 digit Nomor Induk Kependudukan/ No KTP Ayah.',
                    'Isi dengan Nama Lengkap Ayah tanpa gelar',
                    'Tanggal lahir ayah dalam
Format: Tahun-Bulan-Tanggan
Contoh: 2000-02-20.',
                    '0 Tidak sekolah
1 PAUD
2 TK / sederajat
3 Putus SD
4 SD / sederajat
5 SMP / sederajat
6 SMA / sederajat
7 Paket A
8 Paket B
9 Paket C
20 D1
21 D2
22 D3
23 D4
30 S1
31 Profesi
32 Sp-1
35 S2
36 S2 Terapan
37 Sp-2
40 S3
41 S3 Terapan
90 Non formal
91 Informal
99 Lainnya',
                    '1 Tidak bekerja
2 Nelayan
3 Petani
4 Peternak
5 PNS/TNI/Polri
6 Karyawan Swasta
7 Pedagang Kecil
8 Pedagang Besar
9 Wiraswasta
10 Wirausaha
11 Buruh
12 Pensiunan
13 Peneliti
14 Tim Ahli / Konsultan
15 Magang
16 Tenaga Pengajar /Instruktur / Fasilitator
17 Pimpinan / Manajerial
98 Sudah Meninggal
99 Lainnya',
                    '11 Kurang dari Rp. 500,000
12 Rp. 500,000 - Rp. 999,999
13 Rp. 1,000,000 - Rp. 1,999,999
14 Rp. 2,000,000 - Rp. 4,999,999
15 Rp. 5,000,000 - Rp. 20,000,000
16 Lebih dari Rp. 20,000,000',
                    'Isi dengan 16 digit Nomor Induk Kependudukan/ No KTP Ibu.',
                    'Isi dengan Nama Lengkap Ibu tanpa gelar',
                    'Tanggal lahir Ibu dalam
Format: Tahun-Bulan-Tanggan
Contoh: 2000-02-20.',
                    '0 Tidak sekolah
1 PAUD
2 TK / sederajat
3 Putus SD
4 SD / sederajat
5 SMP / sederajat
6 SMA / sederajat
7 Paket A
8 Paket B
9 Paket C
20 D1
21 D2
22 D3
23 D4
30 S1
31 Profesi
32 Sp-1
35 S2
36 S2 Terapan
37 Sp-2
40 S3
41 S3 Terapan
90 Non formal
91 Informal
99 Lainnya',
                    '1 Tidak bekerja
2 Nelayan
3 Petani
4 Peternak
5 PNS/TNI/Polri
6 Karyawan Swasta
7 Pedagang Kecil
8 Pedagang Besar
9 Wiraswasta
10 Wirausaha
11 Buruh
12 Pensiunan
13 Peneliti
14 Tim Ahli / Konsultan
15 Magang
16 Tenaga Pengajar /Instruktur / Fasilitator
17 Pimpinan / Manajerial
98 Sudah Meninggal
99 Lainnya',
                    '11 Kurang dari Rp. 500,000
12 Rp. 500,000 - Rp. 999,999
13 Rp. 1,000,000 - Rp. 1,999,999
14 Rp. 2,000,000 - Rp. 4,999,999
15 Rp. 5,000,000 - Rp. 20,000,000
16 Lebih dari Rp. 20,000,000',
                    'Isi dengan 16 digit Nomor Induk Kependudukan/ No KTP Wali.',
                    'Isi dengan Nama Lengkap Wali tanpa gelar',
                    'Tanggal lahir Wali dalam
Format: Tahun-Bulan-Tanggan
Contoh: 2000-02-20.',
                    '0 Tidak sekolah
1 PAUD
2 TK / sederajat
3 Putus SD
4 SD / sederajat
5 SMP / sederajat
6 SMA / sederajat
7 Paket A
8 Paket B
9 Paket C
20 D1
21 D2
22 D3
23 D4
30 S1
31 Profesi
32 Sp-1
35 S2
36 S2 Terapan
37 Sp-2
40 S3
41 S3 Terapan
90 Non formal
91 Informal
99 Lainnya',
                    '1 Tidak bekerja
2 Nelayan
3 Petani
4 Peternak
5 PNS/TNI/Polri
6 Karyawan Swasta
7 Pedagang Kecil
8 Pedagang Besar
9 Wiraswasta
10 Wirausaha
11 Buruh
12 Pensiunan
13 Peneliti
14 Tim Ahli / Konsultan
15 Magang
16 Tenaga Pengajar /Instruktur / Fasilitator
17 Pimpinan / Manajerial
98 Sudah Meninggal
99 Lainnya',
                    '11 Kurang dari Rp. 500,000
12 Rp. 500,000 - Rp. 999,999
13 Rp. 1,000,000 - Rp. 1,999,999
14 Rp. 2,000,000 - Rp. 4,999,999
15 Rp. 5,000,000 - Rp. 20,000,000
16 Lebih dari Rp. 20,000,000',
                    'Kode Prodi',
                    'Tidak Wajib diisi',
                    'Tidak Wajib diisi',
                    'Tidak Wajib diisi',
                    'Tidak Wajib diisi',
                    'Tidak Wajib diisi',
                    'Tidak Wajib diisi',
                    '1: Mandiri
2: Beasiswa Tidak Penuh
3: Beasiswa Penuh',
                    'Isi dengan angka tanpa koma atau titik.
contoh : 5000000',
                ];

                // Generate comments dynamically for columns A to BB
                $columnIndex = 'A';
                foreach ($comments as $index => $comment) {
                    $sheet->getComment($columnIndex . '1')->getText()->createTextRun($comment);
                    $columnIndex++;
                }
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $greenColumns = [
            'J', 'P', 'Q', 'R', 'S', 'T', 'W', 'X', 'Y', 'Z', 
            'AA', 'AB', 'AC', 'AD', 'AE', 'AG', 'AH', 'AI', 'AJ', 
            'AK', 'AL', 'AM', 'AN', 'AO', 'AQ', 'AR', 'AS', 'AT', 
            'AU', 'AV'
        ];
    
        $columns = [
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 
            'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 
            'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 
            'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 
            'AS', 'AT', 'AU', 'AV', 'AW'
        ];
    
        foreach ($columns as $column) {
            $cell = $column . '1'; 
    
            if (in_array($column, $greenColumns)) {
                $sheet->getStyle($cell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => '000000']], // Black bold font
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => '90EE90'], // Green fill
                    ],
                    'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
                ]);
            } else {
                $sheet->getStyle($cell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']], // White bold font
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => 'FF0000'], // Red fill
                    ],
                    'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
                ]);
            }
        }
    }
    

    public function map($mahasiswa): array
    {
        return [
            $mahasiswa->NIM,
            $mahasiswa->nama,
            $mahasiswa->tempat_lahir,
            $mahasiswa->tanggal_lahir,
            $mahasiswa->jenis_kelamin,
            $mahasiswa->NIK,
            $mahasiswa->agama,
            $mahasiswa->nisn ?? null,
            $mahasiswa->jalur_pendaftaran,
            $mahasiswa->NPWP ?? null,
            $mahasiswa->kewarganegaraan,
            $mahasiswa->jenis_pendaftaran,
            $mahasiswa->tanggal_masuk_kuliah,
            optional($mahasiswa->semester)->nama_semester ?? null,
            $mahasiswa->alamat,
            $mahasiswa->kode_pos ?? null,
            $mahasiswa->jenis_tempat_tinggal,
            $mahasiswa->jenis_transportasi,
            $mahasiswa->telp_rumah ?? null,
            $mahasiswa->no_hp,
            $mahasiswa->email,
            $mahasiswa->terima_kps,
            $mahasiswa->no_kps ?? null,
            optional($mahasiswa->orangtuaWali)->NIK_ayah ?? null,
            optional($mahasiswa->orangtuaWali)->nama_ayah ?? null,
            optional($mahasiswa->orangtuaWali)->tanggal_lahir_ayah ?? null,
            optional($mahasiswa->orangtuaWali)->pendidikan_ayah ?? null,
            optional($mahasiswa->orangtuaWali)->pekerjaan_ayah ?? null,
            optional($mahasiswa->orangtuaWali)->penghasilan_ayah ?? null,
            optional($mahasiswa->orangtuaWali)->NIK_ibu ?? null,
            optional($mahasiswa->orangtuaWali)->nama_ibu ?? null,
            optional($mahasiswa->orangtuaWali)->tanggal_lahir_ibu ?? null,
            optional($mahasiswa->orangtuaWali)->pendidikan_ibu ?? null,
            optional($mahasiswa->orangtuaWali)->pekerjaan_ibu ?? null,
            optional($mahasiswa->orangtuaWali)->penghasilan_ibu ?? null,
            optional($mahasiswa->orangtuaWali)->nama_wali ?? null,
            optional($mahasiswa->orangtuaWali)->tanggal_lahir_wali ?? null,
            optional($mahasiswa->orangtuaWali)->pendidikan_wali ?? null,
            optional($mahasiswa->orangtuaWali)->pekerjaan_wali ?? null,
            optional($mahasiswa->orangtuaWali)->penghasilan_wali ?? null,
            optional($mahasiswa->prodi)->kode_prodi ?? null,
            optional($mahasiswa->prodi)->nama_prodi ?? null,
            $mahasiswa->sks_diakui ?? null,
            $mahasiswa->kode_pt_asal ?? null,
            $mahasiswa->nama_pt_asal ?? null,
            $mahasiswa->kode_prodi_asal ?? null,
            $mahasiswa->nama_prodi_asal ?? null,
            $mahasiswa->jenis_pembiayaan,
            $mahasiswa->jumlah_biaya_masuk,
        ];
    }
}
