<?php

namespace App\Livewire\Component;

use Livewire\Component;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use Illuminate\Support\Facades\DB;
use App\Models\Prodi;
use App\Models\PeriodeEMonev;

class ChartEmonev extends Component
{
    public $chartData = [];
    public $x;

    public function mount($x)
    {
        $this->x = $x;

        $pertanyaan = Pertanyaan::all();

        $query = Jawaban::join('emonev', 'jawaban.id_emonev', '=', 'emonev.id_emonev')
            ->join('pertanyaan', 'jawaban.id_pertanyaan', '=', 'pertanyaan.id_pertanyaan')
            ->join('dosen', 'emonev.nidn', '=', 'dosen.nidn')
            ->join('periode_emonev', 'emonev.nama_periode', '=', 'periode_emonev.nama_periode')
            ->select('dosen.nama_dosen', 'periode_emonev.nama_periode');

        $query->where('periode_emonev.nama_periode', $this->x);

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

        $query->addSelect(DB::raw('(' . implode(' + ', $totalExpr) . ') AS total_skor'));

        $query->groupBy('dosen.nidn', 'dosen.nama_dosen', 'periode_emonev.nama_periode');

        $dosenData = $query->get()->map(function ($item) {
            return [
                'nama_dosen' => $item->nama_dosen,
                'total_skor' => (int) $item->total_skor,
            ];
        });

        // Simpan warna acak untuk konsistensi chart
        if (!session()->has('chartColors') || count(session('chartColors')) < $dosenData->count()) {
            session()->put('chartColors', $this->generateRandomColors($dosenData->count()));
        }

        $chartColors = session()->get('chartColors');

        $this->chartData = [
            'labels' => $dosenData->pluck('nama_dosen'),
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



    private function generateRandomColors($count)
    {
        $colors = [];
        for ($i = 0; $i < $count; $i++) {
            $colors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }
        return $colors;
    }
    public function render()
    {
        return view('livewire.component.chart-emonev');
    }
}
