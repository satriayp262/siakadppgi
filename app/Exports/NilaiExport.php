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
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;


class NilaiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $id_kelas, $id_mata_kuliah;
    protected $headers;
    protected $aktifitas;

    public function __construct($id_kelas, $id_mata_kuliah)
    {
        $this->id_kelas = $id_kelas;
        $this->id_mata_kuliah = $id_mata_kuliah;
        $this->aktifitas = Aktifitas::where('id_kelas', $this->id_kelas)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->select('id_aktifitas', 'nama_aktifitas')
            ->get();
        $this->headers = $this->aktifitas->pluck('nama_aktifitas')->toArray();
    }


    public function collection()
    {
        return Mahasiswa::whereIn(
            'NIM',
            Nilai::whereIn('id_aktifitas', $this->aktifitas->pluck('id_aktifitas'))->pluck('NIM')
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
            $lastColumn = Coordinate::stringFromColumnIndex($headerCount);
            $sheet->getStyle("C1:{$lastColumn}1")->applyFromArray([

                'fill' => [
                    'fillType' => 'solid',
                    'color' => ['rgb' => 'FFDE21'],
                ],
                'font' => ['bold' => true],
            ]);
        }
    }
}
