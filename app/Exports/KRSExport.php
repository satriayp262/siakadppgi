<?php

namespace App\Exports;

use App\Models\KRS;
use App\Models\Semester;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;

class KRSExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithEvents
{

    protected $semester;
    protected $NIM;

    public function __construct($semester, $NIM)
    {
        $this->semester = Semester::where('nama_semester', $semester)->first()->id_semester ?? null;
        $this->NIM = $NIM ?? null;
    }
    public function query()
    {
        if ($this->NIM && $this->semester) {
            // Both NIM and semester are specified
            return KRS::query()
                ->where('NIM', $this->NIM)
                ->where('id_semester', $this->semester)
                ->orderBy('NIM', 'asc') // Primary: Order by NIM
                ->orderBy('id_kelas', 'asc'); // Secondary: Order by id_kelas
        } else if ($this->NIM && !$this->semester) {
            // NIM is specified, but semester is not
            return KRS::query()
                ->where('NIM', $this->NIM)
                ->join('semester', 'krs.id_semester', '=', 'semester.id_semester') // Join with semester
                ->orderBy('NIM', 'asc') // Primary: Order by NIM
                ->orderByDesc('semester.nama_semester') // Secondary: Order by nama_semester descending
                ->orderBy('id_kelas', 'asc') // Tertiary: Order by id_kelas
                ->select('krs.*'); // Select only KRS columns
        } else if ($this->semester && !$this->NIM) {
            // Semester is specified, but NIM is not
            return KRS::query()
                ->where('id_semester', $this->semester)
                ->orderBy('NIM', 'asc') // Primary: Order by NIM
                ->orderBy('id_kelas', 'asc'); // Secondary: Order by id_kelas
        } else {
            // Neither NIM nor semester is specified
            return KRS::query()
                ->join('semester', 'krs.id_semester', '=', 'semester.id_semester') // Join with semester
                ->orderBy('NIM', 'asc') // Primary: Order by NIM
                ->orderByDesc('semester.nama_semester') // Secondary: Order by nama_semester
                ->orderBy('id_kelas', 'asc') // Tertiary: Order by id_kelas
                ->select('krs.*'); // Select only KRS columns
        }
        
        
        
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'Semester',
            'Kode Mata Kuliah',
            'Nama Mata Kuliah',
            'Nama Kelas',
            'Kode Prodi',
            'Nama Prodi',
            'Nilai Huruf',
            'Nilai Indeks',
            'Nilai Angka',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $comments = [
                    'NIM:
Isi dengan Nomor Induk Mahasiswa/ Nomor Pokok Mahasiswa. 

Warna Merah : Wajib diisi
',
                    'Nama Mahasiswa :
Disarankan untuk diisi,
jika terdapat nim duplikat, dengan Nama Mahasiswa yang berbeda. 

Warna Kuning : Diisi jika ada mahasiswa yang memiliki NIM/NPM sama

',
                    'Semester :
Contoh : 
2021/2022 Ganjil diisi =20211
2021/2022 Genap diisi =20212
2021/2022 Pendek diisi =20213

Warna Merah : Wajib diisi
',
                    'Kode Matakuliah :
Isi dengan Kode Mata Kuliah
Warna Merah : Wajib Diisi

',
                    'Nama Matakuliah :

Disarankan untuk diisi jika terdapat kode Mata kuliah duplikat. Dianggap duplikat jika Kode Mata kuliah sama tetapi dengan Nama Mata Kuliah yang berbeda

Warna Kuning : Diisi jika duplikat.
 
',
                    'Nama Kelas :
Isi dengan Nama Kelas. 
Maksimal 5 karakter
Warna Merah : Wajib Diisi

',
                    'Kode Prodi :
Kode Program Studi Dikti

Warna Merah : Wajib diisi
',
                    'Nama Prodi :
Tidak wajib diisi, diisi jika ada 2 prodi atau lebih dengan kode prodi dikti sama
Contoh : 
12345 : Keperawatan Bandung
12345 : Keperawatan Bogor

Warna Kuning : Diisi Jika ada prodi dengan kode sama
',
                    'Nilai Huruf
Isi dengan Nilai Huruf misalnya : A, B , C dst

Warna Hijau : Boleh Kosong
',
                    'Nilai Indeks
Isi dengan Angka misalnya :
4, 3 , 2 , 1 , 0

Warna hijau : Boleh Kosong
',
                    'Nilai Angka
Isi dengan Angka misalnya :
90, 80.50 , 70.98 
Gunakan . (titik) jika bilangan desimal

Warna Hijau : Boleh Kosong
',
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
            'I',
            'J',
            'K'
        ];
        $yellowColumns = [
            'B',
            'E',
            'H'
        ];

        $columns = [
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K'
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
            } else if (in_array($column, $yellowColumns)) {
                $sheet->getStyle($cell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => '000000']], // Black bold font
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => 'FFDE21'], // Yellow fill
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


    public function map($krs): array
    {
        return [
            $krs->NIM,
            optional($krs->mahasiswa)->nama ?? null,
            optional($krs->semester)->nama_semester ?? null,
            optional($krs->matkul)->kode_mata_kuliah ?? null,
            optional($krs->matkul)->nama_mata_kuliah ?? null,
            optional($krs->kelas)->nama_kelas ?? null,
            optional($krs->prodi)->kode_prodi ?? null,
            optional($krs->prodi)->nama_prodi ?? null,
            $krs->nilai_huruf,
            $krs->nilai_index,
            $krs->nilai_angka,
        ];
    }
}
