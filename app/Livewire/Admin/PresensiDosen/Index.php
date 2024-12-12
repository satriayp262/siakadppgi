<?php

namespace App\Livewire\Admin\PresensiDosen;

use Livewire\Component;
use App\Models\Dosen;
use Livewire\WithPagination;
use App\Models\Prodi;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PresensiDosenExport;

class Index extends Component
{
    use WithPagination;
    public $month, $year, $search = '';
    public $selectedProdi;

    public function mount()
    {
        $this->month = now()->month;
        $this->year = now()->year;
        $this->selectedProdi = '';
    }

    public function updatedMonth()
    {
        $this->resetPage();
    }

    public function updatedYear()
    {
        $this->resetPage();
    }

    public function exportExcel()
    {
        // Format bulan untuk nama file
        $bulan = now()->month($this->month)->format('F'); // Format bulan dalam huruf

        // Menggunakan class PresensiDosenExport untuk mengekspor data
        return Excel::download(
            new PresensiDosenExport($this->month, $this->year, $this->search, $this->selectedProdi),
            'presensi_dosen_' . $bulan . '.xlsx'
        );
    }

    public function render()
    {
        $prodis = Prodi::all();
        $dosenWithTokens = Dosen::withCount(['tokens' => function ($query) {
            $query->whereMonth('token.created_at', $this->month)
                ->whereYear('token.created_at', $this->year);
        }])
            ->where(function ($query) {
                $query->where('nama_dosen', 'like', '%' . $this->search . '%')
                    ->orWhere('nidn', 'like', '%' . $this->search . '%')
                    ->orWhereHas('prodi', function ($q) {
                        $q->where('nama_prodi', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->selectedProdi, function ($query) {
                $query->whereHas('prodi', function ($q) {
                    $q->where('kode_prodi', $this->selectedProdi);
                });
            })
            ->paginate(10);

        $dosenWithTokens->getCollection()->transform(function ($dosen) {
            $dosen->total_jam = $dosen->tokens_count * 1.5;
            return $dosen;
        });

        return view('livewire.admin.presensi-dosen.index', [
            'dosenWithTokens' => $dosenWithTokens,
            'prodis' => $prodis,
        ]);
    }
}
