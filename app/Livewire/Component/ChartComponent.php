<?php
namespace App\Livewire\Component;

use Livewire\Component;
use App\Models\Mahasiswa;
use App\Models\Prodi;

class ChartComponent extends Component
{
    public $chartData;

    public function mount()
    {
        $allProdi = Prodi::all();

        $mahasiswaByProdi = Mahasiswa::select('prodi.nama_prodi')
            ->selectRaw('COUNT(*) as count')
            ->join('prodi', 'mahasiswa.kode_prodi', '=', 'prodi.kode_prodi')
            ->groupBy('prodi.nama_prodi')
            ->get();

        $prodiData = $allProdi->map(function($prodi) use ($mahasiswaByProdi) {
            $count = $mahasiswaByProdi->firstWhere('nama_prodi', $prodi->nama_prodi);
            return [
                'nama_prodi' => $prodi->nama_prodi,
                'count' => $count ? $count->count : 0,
            ];
        });

        if (!session()->has('chartColors')) {
            session()->put('chartColors', $this->generateRandomColors($prodiData->count()));
        }

        $chartColors = session()->get('chartColors');

        // Membuat data untuk chart
        $this->chartData = [
            'labels' => $prodiData->pluck('nama_prodi'),
            'datasets' => [
                [
                    'label' => 'Jumlah Mahasiswa',
                    'backgroundColor' => $chartColors,
                    'data' => $prodiData->pluck('count'),
                ],
            ],
        ];
    }

    /**
     * Fungsi untuk menghasilkan warna acak dalam bentuk hex
     *
     * @param int $count
     * @return array
     */
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
        return view('livewire.component.chart-component');
    }
}
