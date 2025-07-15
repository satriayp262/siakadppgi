<?php

namespace App\Livewire\Component;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use App\Models\Dosen;
use function Laravel\Prompts\select;


class ChartEmonevDosen extends Component
{
    public $chartData = [];
    public $x;

    public function mount($x)
    {
        $this->nidn = $x;

        $pertanyaan = Pertanyaan::all();

        $query = Jawaban::join('emonev', 'jawaban.id_emonev', '=', 'emonev.id_emonev')
            ->join('pertanyaan', 'jawaban.id_pertanyaan', '=', 'pertanyaan.id_pertanyaan')
            ->join('dosen', 'emonev.nidn', '=', 'dosen.nidn')
            ->join('matkul', 'emonev.id_mata_kuliah', '=', 'matkul.id_mata_kuliah')
            ->join('periode_emonev', 'emonev.nama_periode', '=', 'periode_emonev.nama_periode')
            ->select('dosen.nama_dosen', 'periode_emonev.nama_periode', 'matkul.nama_mata_kuliah');

        $query->where('dosen.nidn', $this->nidn);

        $totalExpr = [];
        foreach ($pertanyaan as $p) {
            $totalExpr[] = "COALESCE((
                SELECT ROUND(AVG(jwbn.nilai), 0) 
                FROM jawaban jwbn 
                JOIN emonev em ON jwbn.id_emonev = em.id_emonev
                WHERE em.nidn = dosen.nidn 
                AND em.nama_periode = periode_emonev.nama_periode
                AND jwbn.id_pertanyaan = $p->id_pertanyaan
            ), 0)";
        }

        $maxSkorExpr = '(
            SELECT COUNT(DISTINCT jwbn.id_pertanyaan) * 10
            FROM jawaban jwbn
            JOIN emonev em ON jwbn.id_emonev = em.id_emonev
            WHERE em.nidn = dosen.nidn
            AND em.nama_periode = periode_emonev.nama_periode
        )';


        $query->addSelect(DB::raw('ROUND(((' . implode(' + ', $totalExpr) . ') / ' . $maxSkorExpr . ') * 100, 2) AS total_skor'));



        $query->groupBy('dosen.nidn', 'dosen.nama_dosen', 'matkul.nama_mata_kuliah', 'periode_emonev.nama_periode');

        $dosenData = $query->get()->map(function ($item) {
            return [
                'nama_periode' => $item->nama_mata_kuliah . ' ' . $item->nama_periode,
                'total_skor' => (int) $item->total_skor,
            ];
        });

        // Simpan warna acak untuk konsistensi chart
        if (!session()->has('chartColors') || count(session('chartColors')) < $dosenData->count()) {
            session()->put('chartColors', $this->generateRandomColors($dosenData->count()));
        }

        $chartColors = session()->get('chartColors');

        $this->chartData = [
            'labels' => $dosenData->pluck('nama_periode'),
            'datasets' => [
                [
                    'label' => 'Total Skor',
                    'backgroundColor' => $chartColors,
                    'data' => $dosenData->pluck('total_skor'),
                ],
            ],
        ];

        $this->dispatch('renderChart', ['chartData' => $this->chartData]);
    }
    public function render()
    {
        return view('livewire.component.chart-emonev-dosen');
    }
}
