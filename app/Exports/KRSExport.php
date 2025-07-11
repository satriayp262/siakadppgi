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
    protected $prodi;

    public function __construct($semester, $NIM, $prodi)
    {
        $this->semester = $semester ?? null;
        $this->NIM = $NIM ?? null;
        $this->prodi = $prodi ?? null;
    }
    public function query()
    {
        if ($this->prodi && $this->semester && !$this->NIM) {
            return KRS::query()
                ->where('krs.id_prodi', $this->prodi)
                ->where('krs.id_semester', $this->semester)
                ->join('semester', 'krs.id_semester', '=', 'semester.id_semester')
                ->orderBy('krs.id_prodi', 'asc')
                ->orderBy('krs.NIM', 'asc')
                ->orderByDesc('semester.nama_semester')
                ->orderBy('krs.id_kelas', 'asc');

        } else if ($this->prodi && !$this->semester && !$this->NIM) {
            return KRS::query()
                ->where('id_prodi', $this->prodi)
                ->orderBy('id_prodi', 'asc')
                ->join('semester', 'krs.id_semester', '=', 'semester.id_semester')
                ->orderBy('NIM', 'asc')
                ->orderByDesc('semester.nama_semester')
                ->orderBy('id_kelas', 'asc');
        } else if ($this->NIM && $this->semester && !$this->prodi) {
            return KRS::query()
                ->where('NIM', $this->NIM)
                ->where('id_semester', $this->semester)
                ->orderBy('NIM', 'asc')
                ->orderBy('id_kelas', 'asc');
        } else if ($this->NIM && !$this->semester && !$this->prodi) {
            return KRS::query()
                ->where('NIM', $this->NIM)
                ->join('semester', 'krs.id_semester', '=', 'semester.id_semester')
                ->orderBy('NIM', 'asc')
                ->orderByDesc('semester.nama_semester')
                ->orderBy('id_kelas', 'asc')
                ->select('krs.*');
        } else if ($this->semester && !$this->NIM && !$this->prodi) {
            return KRS::query()
                ->where('id_semester', $this->semester)
                ->orderBy('NIM', 'asc')
                ->orderBy('id_kelas', 'asc');
        } else {
            return KRS::query()
                ->join('semester', 'krs.id_semester', '=', 'semester.id_semester') // Join with semester
                ->orderBy('NIM', 'asc')
                ->orderByDesc('semester.nama_semester')
                ->orderBy('id_kelas', 'asc')
                ->select('krs.*');
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
        ];

        foreach ($columns as $column) {
            $cell = $column . '1';

            if (in_array($column, $yellowColumns)) {
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
