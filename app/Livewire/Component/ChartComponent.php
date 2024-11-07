<?php

namespace App\Livewire\Component;

use Livewire\Component;
use App\Models\Mahasiswa;

class ChartComponent extends Component
{
    public $chartData;

    public function mount()
    {
        // Menghitung jumlah mahasiswa berdasarkan kode program studi
        $mahasiswaByProdi = Mahasiswa::select('kode_prodi')
                                      ->selectRaw('COUNT(*) as count')
                                      ->groupBy('kode_prodi')
                                      ->get();

        // Membuat data untuk chart
        $this->chartData = [
            'labels' => $mahasiswaByProdi->pluck('kode_prodi'), // Mengambil kategori program studi
            'datasets' => [
                [
                    'label' => 'Jumlah Mahasiswa',
                    'backgroundColor' => $this->generateRandomColors($mahasiswaByProdi->count()), // Warna acak untuk setiap kategori
                    'data' => $mahasiswaByProdi->pluck('count'), // Jumlah mahasiswa per program studi
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
            $colors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF)); // Menghasilkan warna hex acak
        }
        return $colors;
    }

    public function render()
    {
        return view('livewire.component.chart-component');
    }
}
