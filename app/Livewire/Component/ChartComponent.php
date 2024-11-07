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
        // Menghitung jumlah mahasiswa berdasarkan nama program studi
        $mahasiswaByProdi = Mahasiswa::select('prodi.nama_prodi')
            ->selectRaw('COUNT(*) as count')
            ->join('prodi', 'mahasiswa.kode_prodi', '=', 'prodi.kode_prodi')
            ->groupBy('prodi.nama_prodi')
            ->get();

        // Membuat data untuk chart
        $this->chartData = [
            'labels' => $mahasiswaByProdi->pluck('nama_prodi'), // Mengambil nama program studi
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
