<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class MahasiswaPresensiExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    protected $semester;
    protected $selectedProdi;

    public function __construct($semester, $selectedProdi)
    {
        $this->semester = $semester;
        $this->selectedProdi = $selectedProdi;
    }

    public function collection()
    {
        $semester = $this->semester;
        $prodi = $this->selectedProdi; // Ganti dari $this->prodi ke $this->selectedProdi

        // Membangun query untuk filter berdasarkan semester dan prodi
        $query = Mahasiswa::with(['presensi' => function ($query) use ($semester) {
            $query->select('nim', 'keterangan', 'created_at');
            if ($semester && $semester != 'semua') {
                $query->whereHas('token', function ($tokenQuery) use ($semester) {
                    $tokenQuery->where('id_semester', $semester);
                });
            }
        }])
            ->withCount([
                'presensi as hadir_count' => function ($query) use ($semester) {
                    $query->where('keterangan', 'Hadir');
                    if ($semester && $semester != 'semua') {
                        $query->whereHas('token', function ($tokenQuery) use ($semester) {
                            $tokenQuery->where('id_semester', $semester);
                        });
                    }
                },
                'presensi as alpha_count' => function ($query) use ($semester) {
                    $query->where('keterangan', 'Alpha');
                    if ($semester && $semester != 'semua') {
                        $query->whereHas('token', function ($tokenQuery) use ($semester) {
                            $tokenQuery->where('id_semester', $semester);
                        });
                    }
                },
                'presensi as ijin_count' => function ($query) use ($semester) {
                    $query->where('keterangan', 'Ijin');
                    if ($semester && $semester != 'semua') {
                        $query->whereHas('token', function ($tokenQuery) use ($semester) {
                            $tokenQuery->where('id_semester', $semester);
                        });
                    }
                },
                'presensi as sakit_count' => function ($query) use ($semester) {
                    $query->where('keterangan', 'Sakit');
                    if ($semester && $semester != 'semua') {
                        $query->whereHas('token', function ($tokenQuery) use ($semester) {
                            $tokenQuery->where('id_semester', $semester);
                        });
                    }
                },
            ]);

        // Filter berdasarkan prodi
        if ($prodi && $prodi != 'semua') {
            $query->where('kode_prodi', $prodi);
        }

        // Ambil data mahasiswa yang sudah difilter
        return $query->get()->map(function ($mahasiswa) {
            return [
                'nama' => $mahasiswa->nama,
                'nim' => $mahasiswa->NIM,
                'prodi' => $mahasiswa->prodi->nama_prodi,
                'hadir' => $mahasiswa->hadir_count,
                'ijin' => $mahasiswa->ijin_count,
                'sakit' => $mahasiswa->sakit_count,
                'alpha' => $mahasiswa->alpha_count,
            ];
        });
    }


    public function headings(): array
    {
        return [
            'Nama Mahasiswa',
            'NIM',
            'Program Studi',
            'Hadir',
            'Ijin',
            'Sakit',
            'Alpha',
        ];
    }

    // Style untuk rata tengah pada heading
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
        ];
    }

    // Event untuk memberi warna di baris heading
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Warna untuk header
                $colors = [
                    'A1' => 'FF00FF00', // Hijau untuk Nama Mahasiswa
                    'B1' => 'FF00FF00', // Hijau untuk NIM
                    'C1' => 'FFFFFF00', // Kuning untuk Program Studi
                    'D1' => 'FF00FF00', // Hijau untuk Hadir
                    'E1' => 'FFFFFF00', // Kuning untuk Ijin
                    'F1' => 'FF0000FF', // Biru untuk Sakit
                    'G1' => 'FFFF0000', // Merah untuk Alpha
                ];

                foreach ($colors as $cell => $color) {
                    $sheet->getStyle($cell)->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => [
                                'argb' => $color,
                            ],
                        ],
                        'font' => [
                            'bold' => true,
                            'color' => ['argb' => 'FFFFFFFF'], // Teks putih
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                    ]);
                }
            },
        ];
    }
}
