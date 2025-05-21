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
    protected $id_mata_kuliah;
    protected $id_kelas;

    public function __construct($semester, $selectedProdi, $id_mata_kuliah = 'semua', $id_kelas = 'semua')
    {
        $this->semester = $semester;
        $this->selectedProdi = $selectedProdi;
        $this->id_mata_kuliah = $id_mata_kuliah;
        $this->id_kelas = $id_kelas;
    }

    public function collection()
    {
        $query = Mahasiswa::query()
            ->with(['prodi'])
            ->when($this->selectedProdi !== 'semua', function ($q) {
                $q->where('kode_prodi', $this->selectedProdi);
            })
            ->withCount([
                'presensi as hadir_count' => function ($query) {
                    $this->applyAllFilters($query, 'Hadir');
                },
                'presensi as alpha_count' => function ($query) {
                    $this->applyAllFilters($query, 'Alpha');
                },
                'presensi as ijin_count' => function ($query) {
                    $this->applyAllFilters($query, 'Ijin');
                },
                'presensi as sakit_count' => function ($query) {
                    $this->applyAllFilters($query, 'Sakit');
                },
            ]);

        return $query->get()->map(function ($mahasiswa) {
            return [
                'nama' => $mahasiswa->nama,
                'nim' => $mahasiswa->NIM,
                'prodi' => $mahasiswa->prodi->nama_prodi ?? '-',
                'hadir' => $mahasiswa->hadir_count,
                'ijin' => $mahasiswa->ijin_count,
                'sakit' => $mahasiswa->sakit_count,
                'alpha' => $mahasiswa->alpha_count,
            ];
        });
    }

    protected function applyAllFilters($query, $keterangan)
    {
        $query->where('keterangan', $keterangan);

        // Apply semester filter if needed
        if ($this->semester !== 'semua') {
            $query->whereHas('matakuliah.semester', function ($q) {
                $q->where('id_semester', $this->semester);
            });
        }

        // Apply mata kuliah filter if needed
        if ($this->id_mata_kuliah !== 'semua') {
            $query->where('id_mata_kuliah', $this->id_mata_kuliah);
        }

        // Apply kelas filter if needed
        if ($this->id_kelas !== 'semua') {
            $query->where('id_kelas', $this->id_kelas);
        }
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

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text and centered
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Set header colors
                $headerStyle = [
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF0070C0'], // Blue header
                    ],
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FFFFFFFF'], // White text
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];

                $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);

                // Auto-size all columns
                foreach (range('A', 'G') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Add conditional formatting for Alpha column (red for high values)
                $alphaColumn = 'G';
                $lastRow = $sheet->getHighestRow();
                $range = $alphaColumn . '2:' . $alphaColumn . $lastRow;

                $conditionalStyles = new \PhpOffice\PhpSpreadsheet\Style\Conditional();
                $conditionalStyles->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CELLIS);
                $conditionalStyles->setOperatorType(\PhpOffice\PhpSpreadsheet\Style\Conditional::OPERATOR_GREATERTHANOREQUAL);
                $conditionalStyles->addCondition(3); // Highlight if 3 or more alphas
                $conditionalStyles->getStyle()->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
                $conditionalStyles->getStyle()->getFont()->setBold(true);

                $conditionalStylesArray = $sheet->getStyle($range)->getConditionalStyles();
                $conditionalStylesArray[] = $conditionalStyles;
                $sheet->getStyle($range)->setConditionalStyles($conditionalStylesArray);
            },
        ];
    }
}
