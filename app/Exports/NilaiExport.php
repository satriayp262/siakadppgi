<?php

namespace App\Exports;

use App\Models\Nilai;
use App\Models\Mahasiswa;
use App\Models\Aktifitas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NilaiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $id_kelas;
    protected $headers;
    protected $aktifitas;

    public function __construct($id_kelas)
    {
        $this->id_kelas = $id_kelas;
        $this->aktifitas = Aktifitas::where('id_kelas', $this->id_kelas)
            ->select('id_aktifitas', 'nama_aktifitas')
            ->get();
        $this->headers = $this->aktifitas->pluck('nama_aktifitas')->toArray();
    }


    public function collection()
    {
        return Mahasiswa::whereIn(
            'NIM',
            Nilai::where('id_kelas', $this->id_kelas)->pluck('NIM')
        )->get();
    }


    public function headings(): array
    {
        return array_merge(['NIM', 'Nama'], $this->headers);
    }

    public function map($mahasiswa): array
    {
        $baseData = [
            $mahasiswa->NIM,
            $mahasiswa->nama,
        ];

        $dynamicData = [];
        foreach ($this->aktifitas as $aktifitas) {
            $nilai = Nilai::where('NIM', $mahasiswa->NIM)
                ->where('id_aktifitas', $aktifitas->id_aktifitas)
                ->first();

            $dynamicData[] = $nilai->nilai ?? '';
        }
        return array_merge($baseData, $dynamicData);
    }

    public function styles(Worksheet $sheet)
    {
        $headerCount = count($this->headings());

        $sheet->getStyle('A1:B1')->applyFromArray([
            'fill' => [
                'fillType' => 'solid',
                'color' => ['rgb' => 'FF0000'],
            ],
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']],
        ]);

        if ($headerCount > 2) {
            $sheet->getStyle('C1:' . chr(64 + $headerCount) . '1')->applyFromArray([
                'fill' => [
                    'fillType' => 'solid',
                    'color' => ['rgb' => 'FFDE21'],
                ],
                'font' => ['bold' => true],
            ]);
        }
    }
}
