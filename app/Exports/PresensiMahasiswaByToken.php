<?php

namespace App\Exports;

use App\Models\Presensi;
use App\Models\Mahasiswa;
use App\Models\KRS;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class PresensiMahasiswaByToken implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $id_kelas;
    protected $token;
    protected $id_mata_kuliah;

    public function __construct($id_kelas, $token, $id_mata_kuliah)
    {
        $this->id_kelas = $id_kelas;
        $this->token = $token;
        $this->id_mata_kuliah = $id_mata_kuliah;
    }

    public function collection()
    {
        return Mahasiswa::whereIn('NIM', function($query) {
                $query->select('NIM')
                      ->from('krs')
                      ->where('id_kelas', $this->id_kelas);
            })
            ->with(['prodi'])
            ->orderBy('nama')
            ->get()
            ->map(function($mhs) {
                $presensi = Presensi::where('token', $this->token)
                    ->where('nim', $mhs->NIM)
                    ->first();

                return (object) [
                    'nama' => $mhs->nama,
                    'nim' => $mhs->NIM,
                    'prodi' => $mhs->prodi->nama_prodi ?? '-',
                    'waktu_submit' => $presensi ? $presensi->waktu_submit : null,
                    'keterangan' => $presensi ? $presensi->keterangan : 'Belum Presensi',
                    'alasan' => $presensi ? $presensi->alasan : '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Mahasiswa',
            'NIM',
            'Program Studi',
            'Waktu Presensi',
            'Status',
            'Keterangan/Alasan'
        ];
    }

    public function map($row): array
    {
        return [
            $row->nama,
            $row->nim,
            $row->prodi,
            $row->waktu_submit ? Carbon::parse($row->waktu_submit)->format('d/m/Y H:i') : '-',
            $row->keterangan,
            $row->alasan,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A1:F1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FF4472C4'],
                ],
                'font' => [
                    'color' => ['argb' => 'FFFFFFFF'],
                ],
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }
}
